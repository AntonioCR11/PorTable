<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Migrasi\postMigrasi;
use App\Models\Migrasi\reservationMigrasi;
use App\Models\Migrasi\restaurantMigrasi;
use App\Models\Migrasi\transactionMigrasi;
use App\Models\Migrasi\userMigrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RestaurantController extends Controller
{
    /** Tells the view that the current active view is a home page */
    private static $ACTIVE_HOME = "home";

    /** Tells the view that the current active view is a history page */
    private static $ACTIVE_HISTORY = "history";

    /** Tells the view that the current active view is a statistic page */
    private static $ACTIVE_STATISTIC = "statistic";

    /** Tells any type of pagination that the limit of pagination is 50 */
    public static $PAGINATION_LIMIT = 50;

    /**
     * Retrieve the current logged restaurant account and return it to the caller of the function.
     *
     * @return restaurantMigrasi|null The restaurant eloquent model if found, else return null.
     */
    private function getAuthRestaurant(Request $request)
    {
        // Get restaurant model
        $restaurant = restaurantMigrasi::where('user_id', activeUser()->id)->get()[0];

        return $restaurant;
    }

    /**
     * Get the home page view of the restaurant and return it as a response.
     */
    public function getHomePage(Request $request)
    {
        return view('restaurant.restaurant-home', [
            'active' => RestaurantController::$ACTIVE_HOME,
            'restaurant' => $this->getAuthRestaurant($request)
        ]);
    }

    /**
     * Get the history page view of the restaurant and return it as a response.
     */
    public function getHistoryPage(Request $request)
    {
        return view('restaurant.restaurant-history', [
            'active' => RestaurantController::$ACTIVE_HISTORY,
            'restaurant' => $this->getAuthRestaurant($request)
        ]);
    }

    /**
     * Get the statistic page view of the restaurant and return it as a response.
     */
    public function getStatisticPage(Request $request)
    {
        return view('restaurant.restaurant-statistic', [
            'active' => RestaurantController::$ACTIVE_STATISTIC,
            'restaurant' => $this->getAuthRestaurant($request)
        ]);
    }

    /**
     * Update the reservation with the specified id in the URL status to attended.
     */
    public function confirmReservation(Request $request)
    {
        // TODO: Confirm the status of the reservation and update the database.
        $reservation = reservationMigrasi::find($request->id);
        $restaurant = restaurantMigrasi::find($reservation->restaurant_id);
        $user = userMigrasi::find($reservation->user_id);
        
        postMigrasi::create([
            'title'=> 'Reservation Acceptance',
            'caption' => "Hello dear mr/mrs $user->full_name thankyou for your reservation we wellcome you to come on $reservation->reservation_date_time",
            'user_id' => $user->id,
            'status' => 0
        ]);
        $reservation->payment_status = 3;
        $reservation->save();
        return redirect()->back();
    }

    /**
     * Update the reservation with the specified id in the URL status to rejected.
     */
    public function rejectReservation(Request $request)
    {
        // TODO: Reject the status of the reservation and update the database.
        $reservation = reservationMigrasi::find($request->id);
        $restaurant = restaurantMigrasi::find($reservation->restaurant_id);
        $user = userMigrasi::find($reservation->user_id);
        // dd($restaurant->id);
        $transaction = transactionMigrasi::create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'reservation_id' => $reservation->id,
            'payment_amount' => $restaurant->price,
            'payment_date_at' => now()
        ]);
        postMigrasi::create([
            'title'=> 'Reservation Refusal',
            'caption' => "Hello dear mr/mrs $user->full_name we apologize for the refusal of the reservation",
            'user_id' => $user->id,
            'status' => 0
        ]);
        $reservation->payment_status = 2;
        $reservation->save();
        return redirect()->back();
    }

    /**
     * Update the restaurant data with the given properties.
     */
    public function updateRestaurant(Request $request)
    {
        $request->validate([
            'tableRow' => ['required', 'numeric', 'max:20', 'min:1'],
            'tableColumn' => ['required', 'numeric', 'max:20', 'min:1'],
            'restaurantAddress' => ['required'],
            'restaurantPhone' => ['required'],
            'restaurantDescription' => ['required'],
            'openTime' => ['required'],
            'shifts' => ['required', 'numeric'],
            'reservationCost' => ['required', 'numeric'],
        ]);

        // Get the restaurant
        $restaurant = $this->getAuthRestaurant($request);

        if ($request->newPassword != null) {
            $request->validate([
                'newPassword' => ['confirmed'],
                'restaurantPassword' => ['required'],
            ]);
            if (Hash::check($request->currentPassword, $restaurant->user->password)) {
                return redirect()->intended("/restaurant/home")->with('err', 'Password is not correct!');
            }
        }

        $restaurant->row = $request->tableRow;
        $restaurant->col = $request->tableColumn;
        $restaurant->address = $request->restaurantAddress;
        $restaurant->phone = $request->restaurantPhone;
        $restaurant->description = $request->restaurantDescription;
        $restaurant->start_time = (int)explode(':', $request->openTime)[0];
        $restaurant->shifts = $request->shifts;
        $restaurant->price = $request->reservationCost;
        $restaurant->save();

        return redirect()->intended("/restaurant/home")->with('success', 'Successfully changed settings!');
    }

    /**
     * Get all available restaurant table from the authenticated user.
     */
    public function getRestaurantTables(Request $request)
    {
        $restaurant = $this->getAuthRestaurant($request);

        $reservations = reservationMigrasi::where("restaurant_id", $restaurant->id)
            ->where("reservation_date_time", "==", DB::raw("NOW()"))
            ->orderBy("reservation_date_time", "asc")
            ->get();

        return view('restaurant.partial.table-reservation', [
            "restaurant" => $restaurant,
            "reservations" => $reservations,
        ]);
    }

    /**
     * Get the reservations for the authenticated restaurant with the date more than the current date.
     */
    public function getReservations(Request $request)
    {
        $restaurant = $this->getAuthRestaurant($request);

        // Get reservations in ascending order and more than today
        $reservations = reservationMigrasi::where("restaurant_id", $restaurant->id)
            ->where('payment_status','=','1')
            ->orderBy("reservation_date_time", "asc")
            ->get();
        return view('restaurant.partial.reservation-card', ["reservations" => $reservations]);
    }

    /**
     * Handle an AJAX request and return a response of table rows containing the reservation history of the authenticated restaurant.
     */
    public function getReservationHistory(Request $request)
    {
        $restaurant = $this->getAuthRestaurant($request);


        $reservations = reservationMigrasi::withTrashed()
            ->select(DB::raw('count(*) as reservation_count'))
            ->where("restaurant_id", $restaurant->id)
            ->first();

        // Get the pagination limit
        $paginationSize = ceil($reservations->reservation_count / RestaurantController::$PAGINATION_LIMIT);

        // constraint the target page to not exceed the limit
        $page = (int)($request->page);
        $page = max(1, $page);
        $page = min($paginationSize, $page);

        $reservationHistory = reservationMigrasi::withTrashed()
            ->where("restaurant_id", $restaurant->id)
            ->orderBy("reservation_date_time", "desc")
            ->offset(RestaurantController::$PAGINATION_LIMIT * ($page - 1))
            ->limit(RestaurantController::$PAGINATION_LIMIT)
            ->get();

        return view("restaurant.partial.history-row", ['reservations' => $reservationHistory]);
    }

    /**
     * Get all the reservation history that has been made to the current authenticated restaurant.
     * Respondes to the ajax resquest to generate a report for a restaurant when requesting to download a pdf of reservation history.
     */
    public function getAllRestaurantHistory(Request $request)
    {
        $restaurant = $this->getAuthRestaurant($request);

        if (!isset($request->timeLimit)) {
            $reservations = reservationMigrasi::withTrashed()
            ->join("users", "reservations.user_id", "=", "users.id")
            ->join("tables", "reservations.table_id", "=", "tables.id")
            ->select("reservations.id", "users.full_name", "tables.seats", "reservations.reservation_date_time", "reservations.created_at", "reservations.payment_status", "reservations.deleted_at", DB::raw('CASE
                WHEN reservations.deleted_at <> NULL THEN "Rejected"
                ELSE "Accepted"
            END as "status"'))
            ->where("reservations.restaurant_id", $restaurant->id)
            ->orderBy("reservation_date_time", "desc")
            ->get();
        }
        else {
            $reservations = reservationMigrasi::withTrashed()
            ->join("users", "reservations.user_id", "=", "users.id")
            ->join("tables", "reservations.table_id", "=", "tables.id")
            ->select("reservations.id", "users.full_name", "tables.seats", "reservations.reservation_date_time", "reservations.created_at", "reservations.payment_status", "reservations.deleted_at", DB::raw('CASE
                WHEN reservations.deleted_at <> NULL THEN "Rejected"
                ELSE "Accepted"
            END as "status"'))
            ->where("reservations.restaurant_id", $restaurant->id)
            ->where("reservations.created_at", ">=", DB::raw("DATE_SUB(NOW(), 1 YEAR)"))
            ->orderBy("reservation_date_time", "desc")
            ->get();
        }

        $data = [];
        for ($i = 0; $i < count($reservations); $i++) {
            $shortenedName = substr($reservations[$i]['full_name'], 0, 28);
            if ($shortenedName != $reservations[$i]['full_name']) $shortenedName .= "...";

            $reservationDate = date_format(date_create($reservations[$i]['reservation_date_time']), "d-m-Y h:i");

            $reservationCreated = date_format(date_create($reservations[$i]['created_at']), "d-m-Y h:i");

            // $data[] = [
            //     "id" => $reservations[$i]['id'] . "",
            //     "reserver" => $shortenedName,
            //     "seats" => $reservations[$i]['seats'] . "",
            //     "reservation_date" => $reservationDate,
            //     "created" => $reservationCreated,
            //     "status" => $reservations[$i]['status']
            // ];
            $data[] = [
                $reservations[$i]['id'] . "",
                $shortenedName,
                $reservations[$i]['seats'] . "",
                $reservationDate,
                $reservationCreated,
                $reservations[$i]['status']
            ];
        }

        return $data;
    }

    /**
     * Handle an AJAX request and return a response of a series of pagination buttons.
     */
    public function getReservationPagination(Request $request)
    {
        $restaurant = $this->getAuthRestaurant($request);

        $reservations = reservationMigrasi::withTrashed()
            ->select(DB::raw('count(*) as reservation_count'))
            ->where("restaurant_id", $restaurant->id)
            ->first();

        // Get the pagination limit
        $paginationSize = ceil($reservations->reservation_count / RestaurantController::$PAGINATION_LIMIT);

        // constraint the target page to not exceed limit
        $page = (int)($request->page);
        $page = max(1, $page);
        $page = min($paginationSize, $page);

        return view("restaurant.partial.history-pagination", [
            'paginationSize' => $paginationSize,
            'page' => $page,
        ]);
    }

    /**
     * Retrieve all revenues that the current authenticated restaurant receive from the targeted year.
     */
    public function getRestaurantRevenue(Request $request)
    {
        $restaurant = $this->getAuthRestaurant($request);

        // Fetch the transactions in the targeted year
        $transactions = transactionMigrasi::where(DB::raw('YEAR(payment_date_at)') , "=", "$request->year")
            ->where("restaurant_id", $restaurant->id)
            ->get();

        $revenues = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach($transactions as $transaction) {
            $reservation = $transaction->reservation->withTrashed()->first();

            // Check whether the reservation has been cancelled or not.
            if (!$reservation->trashed()) {
                // Get the transaction month and add to the array of revenue according what month is it.
                $month = date_format(date_create($transaction->payment_date_at), "m");

                $month = (int)$month - 1;

                // Apply the additional revenue to the correspoding index (month)
                $revenues[$month] += $transaction->payment_amount;
            }
        }

        return $revenues;
    }

    /**
     * Retrieve the total amount of revenue in the current authenticated restaurant.
     */
    public function getTotalRevenue(Request $request)
    {
        $restaurant = $this->getAuthRestaurant($request);

        // Fetch the transactions in the targeted year
        $revenueSum = transactionMigrasi::select(DB::raw("SUM(payment_amount) as revenue"))
            ->where("restaurant_id", $restaurant->id)
            ->first();

        return $revenueSum->revenue;
    }

    /**
     * Retrieve the total order that has been made to the current authenticated restaurant.
     */
    public function getTotalOrder(Request $request)
    {
        $restaurant = $this->getAuthRestaurant($request);

        // Fetch the transactions in the targeted year
        $totalOrder = transactionMigrasi::select(DB::raw("count(*) as orders"))
            ->where("transactions.restaurant_id", $restaurant->id)
            ->join("reservations", "transactions.reservation_id", "=", "reservations.id")
            ->where("reservations.deleted_at", null)
            ->first();

        return $totalOrder->orders;
    }

    public function getAudienceGrowth(Request $request)
    {
        $restaurant = $this->getAuthRestaurant($request);

        // Fetch the total reservation from the last 1 month
        $reservations = transactionMigrasi::select(DB::raw("COUNT(*) as growth"))
            ->where("payment_date_at", ">", DB::raw("DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)"))
            ->where("restaurant_id", $restaurant->id)
            ->first();

        return $reservations->growth;
    }
}
