<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Migrasi\postMigrasi;
use App\Models\Migrasi\restaurantMigrasi;
use App\Models\Migrasi\transactionMigrasi;
use App\Models\Migrasi\userMigrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function masterDashboard(Request $request)
    {
        $currPage = "dashboard";
        $totaltransactions= DB::select("select SUM(t.payment_amount) as sum
        FROM transactions t
        JOIN reservations r ON r.id = t.reservation_id
        WHERE r.payment_status = ?",[1]);
        $totalOrder = transactionMigrasi::all();
        $countTotalOrder = $totalOrder->count();
        $monthNow = date("m");
        $audienceGrowth = userMigrasi::whereMonth('created_at','=',$monthNow)->get();

        $topSales = DB::select("select r.id, r.full_name, r.address, SUM(t.payment_amount)
        FROM restaurants r
        JOIN transactions t ON r.id = t.restaurant_id
        group by r.id, r.id, r.full_name, r.address");

        $totalIncome = DB::select("select sum(payment_amount) as sum
        from transactions t
        join restaurants r2 on t.restaurant_id = r2.id
        join reservations r on r.id = t.reservation_id
        where r.payment_status = ?
        group by r2.id",[1]);

        $totalOrder = DB::select("select COUNT(r.id) AS totalorder, r.id
        FROM transactions t
        JOIN reservations r2 ON r2.id = t.reservation_id
        JOIN restaurants r ON r.id = r2.restaurant_id
        WHERE r2.payment_status = ?
        GROUP BY r.id
        ORDER BY totalorder desc",[1]);
        $tes = userMigrasi::all()->count();
        $temp = [];
        $int = -1;
        for ($i=0; $i < $tes; $i++) {
            foreach ($totalOrder as $key =>$total) {
                if($i == $total->id){
                    $int = $total->totalorder;
                }
            }
            if($int != -1){
                $temp[] = $int;
            }
            else{
                $temp[] = 0;
            }
            $int = -1;
        }

        // dd($totalOrder,$temp);
        return view('admin.admin_dashboard',compact('currPage','totaltransactions',
        'countTotalOrder','audienceGrowth','topSales','totalIncome','temp'));
    }
    public function masterCustomer(Request $request)
    {
        $currPage = "customer";
        $allUser = userMigrasi::withTrashed()->get();
        $keyword = $request->keyword;
        if($keyword!=null){
            $allUser = userMigrasi::where('username','like',"%$keyword%")->get();
        };
        $tempId = [];
        $restaurantId = [];
        foreach ($allUser as $user) {
            $tempId[] = $user->id;
        }
        $restaurants = restaurantMigrasi::withTrashed()->get();
        foreach ($restaurants as $restaurant) {
            $restaurantId[] = $restaurant->user_id;
        }
        $userList = userMigrasi::withTrashed()
            ->where(function($q) use ($tempId,$restaurantId)
            {
            $q
            ->whereIn('id',$tempId)
            ->whereNotIn('id',$restaurantId)
            ->where('username','<>','admin');
            })
            ->get();
        $countUser = $userList->count();
        $spending = DB::select(DB::raw("select users.id AS id,
        case when SUM(transactions.payment_amount) > 0 then SUM(transactions.payment_amount) ELSE '0' END AS sum
        FROM transactions
        JOIN users ON users.id = transactions.user_id
        JOIN reservations ON reservations.id = transactions.reservation_id
        GROUP BY transactions.user_id, users.id
        ORDER BY users.id"));
        $length = count($spending);
        $tes = userMigrasi::all()->count();
        $tempSpending = [];
        $int = -1;
        for ($i=4; $i <= $tes-1; $i++) {
            foreach ($spending as $key =>$spendings) {
                if($i == $spendings->id){
                    $int = $spendings->sum;
                }
            }
            if($int != -1){
                $tempSpending[] = $int;
            }
            else{
                $tempSpending[] = 0;
            }
            $int = -1;
        }
        // dd($spending,$tempSpending);
        return view('admin.admin_customer',compact('currPage','userList','countUser','keyword','tempSpending'));
    }

    public function banUser(Request $request)
    {
        $selectedUser = userMigrasi::withTrashed()->find($request->id);
        if($selectedUser->trashed()){
            $result = $selectedUser->restore();
        }
        else{
            $result = $selectedUser->delete();
        }
        if($result){
            return redirect()->back()->with('pesan','User Banned');
        }
        else{
            return redirect()->back()->with('pesan','Error');
        }
    }

    public function searchCustomer(Request $request)
    {
        $keyword = $request->keyword;
        return redirect()->route('admin_customerlist',compact('keyword'));
    }

    public function masterRestaurant(Request $request)
    {
        $currPage = "restaurant";
        $allRestaurant = restaurantMigrasi::withTrashed()->get();
        $keyword = $request->keyword;
        // dd($keyword);
        if($keyword!=null){
            $allRestaurant = restaurantMigrasi::where('full_name','like',"%$keyword%")->get();
        };
        //dd($allRestaurant);
        $countRestaurant = restaurantMigrasi::all()->count();
        $lastWeek = DB::select("select ifnull(sum(payment_amount),0) as sum, ifnull(r2.id,0) as id
        from transactions t
        join restaurants r2 on t.restaurant_id = r2.id
        join reservations r on r.id = t.reservation_id
        where r.payment_status = 1
        and payment_date_at between date_sub(now(), interval 1 week) and NOW()
        group by r2.id");
        $tes = restaurantMigrasi::all()->count();
        $tempLastWeek = [];
        $int = -1;
        for ($i=1; $i <= $tes; $i++) {
            foreach ($lastWeek as $key =>$lastweek) {
                if($i == $lastweek->id){
                    $int = $lastweek->sum;
                }
            }
            if($int != -1){
                $tempLastWeek[] = $int;
            }
            else{
                $tempLastWeek[] = 0;
            }
            $int = -1;
        }
        //========================================================
        $lastMonth = DB::select("select ifnull(sum(payment_amount),0) as sum, ifnull(r2.id,0) as id
        from transactions t
        join restaurants r2 on t.restaurant_id = r2.id
        join reservations r on r.id = t.reservation_id
        where r.payment_status = 1
        and payment_date_at between date_sub(now(), interval 1 month) and NOW()
        group by r2.id");
        $tempLastMonth = [];
        $int = -1;
        for ($i=1; $i <= $tes; $i++) {
            foreach ($lastMonth as $key =>$lastmonth) {
                if($i == $lastmonth->id){
                    $int = $lastmonth->sum;
                }
            }
            if($int != -1){
                $tempLastMonth[] = $int;
            }
            else{
                $tempLastMonth[] = 0;
            }
            $int = -1;
        }
        //===========================================================
        $Today = DB::select("select ifnull(sum(payment_amount),0) as sum, ifnull(r2.id,0) as id
        from transactions t
        join restaurants r2 on t.restaurant_id = r2.id
        join reservations r on r.id = t.reservation_id
        where r.payment_status = 1
        and payment_date_at between date_sub(now(), interval 1 day) and NOW()
        group by r2.id");
        $tempToday = [];
        $int = -1;
        for ($i=1; $i <= $tes; $i++) {
            foreach ($Today as $key =>$today) {
                if($i == $today->id){
                    $int = $today->sum;
                }
            }
            if($int != -1){
                $tempToday[] = $int;
            }
            else{
                $tempToday[] = 0;
            }
            $int = -1;
        }
        return view('admin.admin_restaurant',compact('currPage','allRestaurant','countRestaurant','keyword','tempLastWeek','tempLastMonth',
    'tempToday'));
    }

    public function banRestaurant(Request $request)
    {
        $selectedRestaurant = restaurantMigrasi::withTrashed()->find($request->id);
        if($selectedRestaurant->trashed()){
            $result = $selectedRestaurant->restore();
        }
        else{
            $result = $selectedRestaurant->delete();
        }
        if($result){
            return redirect()->back()->with('pesan','Restaurant Banned');
        }
        else{
            return redirect()->back()->with('pesan','Error');
        }
    }

    public function searchRestaurant(Request $request)
    {
        $keyword = $request->keyword;
        return redirect()->route('admin_restaurantlist',compact('keyword'));
    }

    public function masterSettings(Request $request)
    {
        $currPage = "settings";
        $posts = postMigrasi::withTrashed()->get();
        return view('admin.admin_settings',compact('currPage','posts'));
    }
    public function addPost(Request $request)
    {
        //dd($request->all());
        $post = new postMigrasi;
        $post->title = $request->title;
        $post->caption = $request->caption;
        $post->save();
        return redirect()->back();
    }
    public function deletePost(Request $request)
    {
        $selectedPost = postMigrasi::withTrashed()->find($request->id);
        if($selectedPost->trashed()){
            $result = $selectedPost->restore();
        }
        else{
            $result = $selectedPost->delete();
        }
        if($result){
            return redirect()->back()->with('pesan','Post Banned');
        }
        else{
            return redirect()->back()->with('pesan','Error');
        }
    }
    // public function clearFilter(Request $request)
    // {
    //     $keyword = $request->keyword;
    //     $keyword = '';
    //     return redirect()->route('admin_customerlist',compact('keyword'));
    // }
}
