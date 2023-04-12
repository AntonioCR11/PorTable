<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Migrasi\favouriteMigrasi;
use App\Models\Migrasi\postMigrasi;
use App\Models\Migrasi\reservationMigrasi;
use App\Models\Migrasi\restaurantMigrasi;
use App\Models\Migrasi\reviewMigrasi;
use App\Models\Migrasi\transactionMigrasi;
use App\Models\Migrasi\userMigrasi;
use App\Rules\ImageCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // NAVIGATION (NAVBAR) RELATED
    public function masterHome(Request $request)
    {
        $currPage = "home";
        $user = activeUser();

        return view('customer.customer_home',compact('currPage','user'));
    }
    public function masterExplore(Request $request)
    {
        $currPage = "search";
        $restaurants = restaurantMigrasi::all();

        // SEARCH RESTAURANT
        $keyword = $request->keyword;
        $start_price = $request->start_price;
        $end_price = $request->end_price;
        $description = $request->description;
        $location = $request->location;
        $time = $request->time;
        // NO PRICE FILTER
        if($start_price == null){ $start_price = 0; }
        if($end_price == null){ $end_price = 2147483647; }
        // NO TIME FILTER
        if($time == null) {$time = 0;}
        else{ $time = substr($time,0,2); }

        $restaurants = restaurantMigrasi::where(
            function ($q) use ($keyword,$description,$location,$start_price,$end_price,$time)
            {
                $q
                ->where('full_name', 'like', "%$keyword%")
                ->where('address', 'like', "%$location%")
                ->where('price', '>', "$start_price")
                ->where('price', '<', "$end_price")
                ->where('start_time', '>=', "$time")
                ->where('description', 'like', "%$description%");
            }
        )->get();

        $reservations = reservationMigrasi::select("restaurant_id")
            ->selectRaw("count(restaurant_id) as total_reservation")
            ->groupBy("restaurant_id")
            ->orderBy("total_reservation","desc")
            ->limit(10)
            ->get();

        $bestSellerRestaurantId = [];
        foreach ($reservations as $key => $reservation) {
            $bestSellerRestaurantId[] = $reservation->restaurant_id;
        }

        $likelist = favouriteMigrasi::where("user_id",activeUser()->id)->get();
        $likelistId = [];
        foreach ($likelist as $key => $like) {
            $likelistId[] = $like->restaurant_id;
        }

        return view('customer.customer_search',compact('currPage','restaurants','keyword','bestSellerRestaurantId','likelistId'));
    }
    public function masterFavorite(Request $request)
    {
        $currPage = "favorite";

        $likelist = favouriteMigrasi::where("user_id",activeUser()->id)->get();
        $likelistId = [];
        foreach ($likelist as $key => $like) {
            $likelistId[] = $like->restaurant_id;
        }
        $keyword = $request->keyword;
        if($keyword != null){
            $restaurants = restaurantMigrasi::where(
                function ($q) use($keyword,$likelistId)
                {
                    $q
                    ->where('full_name','like',"%$keyword%")
                    ->whereIn("id",$likelistId);
                }
            )->get();
        }else{
            $restaurants = restaurantMigrasi::whereIn("id",$likelistId)->get();
        }

        $reservations = reservationMigrasi::select("restaurant_id")
            ->selectRaw("count(restaurant_id) as total_reservation")
            ->groupBy("restaurant_id")
            ->orderBy("total_reservation","desc")
            ->limit(10)
            ->get();

        $bestSellerRestaurantId = [];
        foreach ($reservations as $key => $reservation) {
            $bestSellerRestaurantId[] = $reservation->restaurant_id;
        }


        return view('customer.customer_favorite',compact('currPage','restaurants','bestSellerRestaurantId','likelistId'));
    }
    public function masterHistory(Request $request)
    {
        $currPage = "history";
        // GET ALL TRANSACTION
        $history = transactionMigrasi::where("user_id",activeUser()->id)->get();

        // GET RESERVATION THAT ALREADY PAID AND HASNT BEEN CONFIRMED BY RESTAURANT
        $activeReservations = reservationMigrasi::where(
            function($q)
            {
                $q
                ->where("user_id",activeUser()->id)
                ->where("payment_status","1");
            }
        )
        ->orderBy("reservation_date_time")
        ->get();
        // $reservation_id = [];
        // foreach ($reservations as $reservation) {
        //     $reservation_id[] = $reservation->id;
        // }
        // // GET FINISHED TRANSACTION
        // $doneTransaction = transactionMigrasi::select("reservation_id")->where(
        //     function($q) use($reservation_id)
        //     {
        //         $q
        //         ->where("user_id",activeUser()->id)
        //         ->whereIn("reservation_id",$reservation_id);
        //     }
        // )->get();
        // dd($doneTransaction);
        return view('customer.customer_history',compact('currPage','history','activeReservations'));
    }
    public function masterProfile(Request $request)
    {
        $currPage = "profile";
        $user = activeUser();
        // GET CLOSEST UPCOMING RESERVATION
        $activeReservation = reservationMigrasi::where(
            function($q)
            {
                $q
                ->where("user_id",activeUser()->id)
                ->where("payment_status","1");
            }
        )
        ->orderBy("reservation_date_time")
        ->first();
        return view('customer.customer_profile',compact('currPage','user','activeReservation'));
    }
    public function masterNotification(Request $request)
    {
        $currPage = "notification";
        $user_notifications = postMigrasi::where("user_id",activeUser()->id)->orderBy("created_at","desc")->get();
        $developer_notifications = postMigrasi::where("user_id","0")->orderBy("created_at","desc")->get();
        foreach ($user_notifications as $user_notif) {
            $notif = postMigrasi::find($user_notif->id);
            $notif->status = 1;
            $notif->save();
        }

        return view('customer.customer_notification',compact('currPage','user_notifications','developer_notifications'));
    }


    // HOME PAGE FUNCTIONS
    public function checkAvailability(Request $request)
    {
        $keyword = $request->restaurant_name;
        $description = $request->restaurant_desc;
        $time = $request->reservation_time;
        return redirect()->route("customer_search",compact("keyword","time","description"));
    }
    public function masterRegister(Request $request)
    {
        $currPage = "register";
        return view('customer.customer_register',compact('currPage'));
    }
    public function registerRestaurant(Request $request)
    {
        // Register validation
        $request->validate([
            'full_name'=>'required',
            'address'=>'required',
            'phone'=>'required|numeric|min:11',
            'open_at'=>'required',
            'shift'=>'required',
            'foto' => ['required', new ImageCount(count(($request->file("foto") != null) ? $request->file("foto") : []))]
        ]);

        // INPUT IMAGE BATCH
        $img_ctr = 1;
        foreach ($request->file("foto") as $file) {
            $file_name = "restaurant_".$img_ctr.".".$file->getClientOriginalExtension();
            $path = "images/restaurant/".$request->full_name;
            $file->storeAs($path,$file_name,"public");
            $img_ctr++;
        }

        // REGISTER RESTAURANT
        $new_restaurant = new restaurantMigrasi;
        $new_restaurant->full_name = $request->full_name;
        $new_restaurant->address = $request->address;
        $new_restaurant->phone = $request->phone;
        $new_restaurant->average_rating = 0;
        $new_restaurant->user_id = activeUser()->id;
        $new_restaurant->col = 0;
        $new_restaurant->row = 0;
        $new_restaurant->price = 20000;
        $new_restaurant->shifts = $request->shift;
        $new_restaurant->start_time = $request->open_at."";
        $new_restaurant->description = $request->description;
        $new_restaurant->verified_at = now();
        $new_restaurant->save();

        // Change user role
        $userId = auth()->id();
        $authUser = userMigrasi::find($userId);
        $authUser->role_id = 3;
        $authUser->save();

        // Store the restaurant information in the session
        $request->session()->put("OPEN_TABLE_RESTAURANT_INFO", $new_restaurant);

        // RETURN REDIRECT TO RESTAURANT HOME
        return redirect()->route("restaurant_home")->with("successMessage","Restaurant account has been registered!");
    }

    // SEARCH/EXPLORE PAGE FUNCTIONS
    public function masterRestaurant(Request $request)
    {
        $currPage = "search";
        $restaurant_name = $request->restaurant_name;
        $restaurant = restaurantMigrasi::where('full_name', $restaurant_name)->first();

        $restaurantReviews = reviewMigrasi::where('restaurant_id', $restaurant->id)->get();
        $userReview = reviewMigrasi::where('restaurant_id', $restaurant->id)->where('user_id', auth("web")->id())->first();

        $reservation = reservationMigrasi::where('restaurant_id', $restaurant->id)->where('user_id', auth("web")->id())->first();

        if (isset($reservation))
            $canReview = true;
        else $canReview = false;

        return view('customer.customer_restaurant', compact('currPage', 'restaurant', 'restaurantReviews', 'userReview', 'canReview'));
    }
    public function searchRestaurant(Request $request)
    {
        $keyword = $request->keyword;
        // RETURN REDIRECT TO EXPLORE WITH KEYWORD
        return redirect()->route("customer_search",compact("keyword"));
    }
    public function filterRestaurant(Request $request)
    {
        $keyword = $request->keyword;
        $start_price = $request->start_price;
        $end_price = $request->end_price;
        $description = $request->description;
        $location = $request->location;
        // RETURN REDIRECT TO EXPLORE WITH KEYWORD
        return redirect()->route("customer_search",compact("keyword","start_price","end_price","description","location"));
    }
    public function generateMap(Request $request)
    {
        // GENERATE MAP AJAX
        $id = $request->restaurant_id;
        $date = $request->reservation_date;

        $restaurant = restaurantMigrasi::find($id);
        $col_length = $restaurant->col;
        $row_length = $restaurant->row;
        $reserved_table = reservationMigrasi::where(
            function($q) use($id,$date)
            {
                $q
                ->where("restaurant_id",$id)
                ->where("reservation_date_time","like","%$date%")
                ->where("payment_status","1");
            }
        )->get();
        $reserved_tableId = [];
        foreach ($reserved_table as $reserved) {
            $reserved_tableId[] = $reserved->table_id;
        }
        return view("customer.partial.restaurant_map",compact("col_length","row_length","reserved_tableId"));
    }
    public function generateForm(Request $request)
    {
        // GENERATE MAP AJAX
        $id = $request->restaurant_id;
        $restaurant = restaurantMigrasi::find($id);

        return view("customer.partial.restaurant_detail",compact("restaurant"));
    }
    public function bookTable(Request $request)
    {
        // BOOK TABLE
        $id = $request->restaurant_id;
        $restaurant = restaurantMigrasi::find($id);
        $table_number = $request->table_number;
        $reservation_date = $request->reservation_date;
        $reservation_time = $request->reservation_time;

        // return view("customer.partial.restaurant_detail",compact("restaurant"));
    }
    public function like_dislike(Request $request)
    {
        // BOOK TABLE
        $restaurant_id = $request->restaurant_id;
        $user_id = $request->user_id;

        $favorite = favouriteMigrasi::where(
            function ($q) use($restaurant_id,$user_id)
            {
                $q
                ->where("user_id","=",$user_id)
                ->where("restaurant_id","=",$restaurant_id);
            }
        )
        ->first();

        if($favorite == null){
            $new_fav = new favouriteMigrasi;
            $new_fav->user_id = $user_id;
            $new_fav->restaurant_id = $restaurant_id;
            $new_fav->save();
            return "1";
        }else{
            $favorite->delete();
            return "2";
        }
    }

    // FAVORITE PAGE FUNCTION
    public function favoriteSearch(Request $request)
    {
        $keyword = $request->keyword;
        return redirect()->route("customer_favorite",compact("keyword"));
    }

    // HISTORY PAGE FUNCTION
    public function cancelTransaction(Request $request)
    {
        $reservation_id = $request->reservation_id;
        $reservation = reservationMigrasi::find($reservation_id);
        $reservation->delete();
        $activeReservations = reservationMigrasi::where(
            function($q)
            {
                $q
                ->where("user_id",activeUser()->id)
                ->where("payment_status","1");
            }
        )
        ->orderBy("reservation_date_time")
        ->get();
        return view("customer.partial.active_reservation",compact("activeReservations"));
    }
    public function cancelClosestUpcomingTransaction(Request $request)
    {
        $reservation_id = $request->reservation_id;
        $reservation = reservationMigrasi::find($reservation_id);
        $reservation->delete();

        // GET CLOSEST UPCOMING RESERVATION
        $activeReservation = reservationMigrasi::where(
            function($q)
            {
                $q
                ->where("user_id",activeUser()->id)
                ->where("payment_status","1");
            }
        )
        ->orderBy("reservation_date_time")
        ->first();
        return view("customer.partial.closestActive_reservation",compact("activeReservation"));
    }

    // PROFILE PAGE FUNCTION
    public function editProfile(Request $request)
    {
        $user_id = activeUser()->id;
        $user = userMigrasi::find($user_id);
        $request->validate([
            'password'=>'required'
        ]);
        if(password_verify($request->password, $user['password'])) {
            // INPUT IMAGE
            if($request->foto != null){
                $file = $request->file("foto");
                $file_name = "pp.".$file->getClientOriginalExtension();
                $path = "images/customer/".$user->full_name;
                $file->storeAs($path,$file_name,"public");
            }
            $user->username = $request->username;
            $user->full_name = $request->firstname.' '.$request->lastname;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->date_of_birth = $request->birthdate;
            $user->save();
            return redirect()->back()->with('pesan','Updated Successfully');
        }
        else{
            return redirect()->back()->with('pesan','Updated Unsuccessfully');
        }
    }

    /**
     * Edits an existing review.
     */
    public function editReview(Request $request)
    {
        $request->validate(['rating' => 'required|numeric']);

        $loggedUserId = auth("web")->id();

        $review = reviewMigrasi::where("user_id", $loggedUserId)->where("restaurant_id", $request->restaurantId)->first();
        $review->rating = $request->rating;
        $review->message = $request->message;
        $review->save();

        // Calculate the average review of the restaurant
        $restaurant = restaurantMigrasi::where("id", $request->restaurantId)->first();
        $newAverage = number_format(reviewMigrasi::select(DB::raw('AVG(rating) as average'))->where("restaurant_id", $request->restaurantId)->first()->average, 1, '.', ',');
        $restaurant->average_rating = $newAverage;
        $restaurant->save();

        return redirect()->back();
    }

    /**
     * Adds a review.
     */
    public function addReview(Request $request)
    {
        $request->validate(['rating' => 'required|numeric']);

        $loggedUserId = auth("web")->id();

        $review = new reviewMigrasi();
        $review->user_id = $loggedUserId;
        $review->restaurant_id = $request->restaurantId;
        $review->rating = $request->rating;
        $review->message = $request->message;
        $review->save();

        // Calculate the average review of the restaurant
        $restaurant = restaurantMigrasi::where("id", $request->restaurantId)->first();
        $newAverage = number_format(reviewMigrasi::select(DB::raw('AVG(rating) as average'))->where("restaurant_id", $request->restaurantId)->first()->average, 1, '.', ',');
        $restaurant->average_rating = $newAverage;
        $restaurant->save();

        return redirect()->back();
    }
}
