<?php

namespace App\Http\Controllers\index;

use App\Http\Controllers\Controller;
use App\Mail\UserVerifyMail;
use App\Models\Migrasi\userMigrasi;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function masterIndex(Request $request)
    {
        return view('index.index');
    }

    public function checkLogin(Request $request)
    {
        // Login validation
        $request->validate([
            'username'=>'required',
            'password'=>'required',
        ]);

        // AUTHENTICATION
        $credential = [
            "username" => $request->username,
            "password" => $request->password
        ];
        if(Auth::attempt($credential)){
            // Check user role
            if(activeUser()->verified_at == null){
                return redirect()->back();
            }
            else{
                if(activeUser()->role->name == "Admin"){
                    return redirect()->route("admin_dashboard");
                }else if(activeUser()->role->name == "Customer"){
                    return redirect()->route("customer_home");
                }else if(activeUser()->role->name == "Restaurant"){
                    return redirect()->route("restaurant_home");
                }
            }
        }else{
            return redirect()->route("index")->with("errorMessage","User not found!");
        }
    }

    public function checkRegister(Request $request)
    {
        // Register validation
        $request->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'username'=>'required',
            'phone'=>'required',
            'email'=> ['required','email'],
            'confirmemail'=>'same:email',
            'password'=>'required|confirmed',
        ]);

        // REGISTER USER
        $new_user = new userMigrasi();
        $new_user->username = $request->username;
        $new_user->password = Hash::make($request->password);
        $new_user->full_name = $request->firstname.' '.$request->lastname;
        $new_user->date_of_birth = date('Y-m-d H:i:s');
        $new_user->address = "";
        $new_user->email = $request->email;
        $new_user->phone = $request->phone;
        $new_user->gender = 0;
        $new_user->balance = 0;
        $new_user->blocked = 0;
        $new_user->role_id = 2;
        $new_user->save();

        // dd(route('verify',$new_user->id));

        Mail::to($request->email)
        ->queue(new UserVerifyMail(route('verify',$new_user->id)));
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        if(Auth::guard('web')->check()){
            Auth::guard('web')->logout();

            // logout from the restaurant session if exists
            $request->session()->pull("OPEN_TABLE_RESTAURANT_INFO");
        }
        return redirect()->route("index");
    }
}
