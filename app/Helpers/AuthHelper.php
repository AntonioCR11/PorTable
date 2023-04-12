<?php

use Illuminate\Support\Facades\Auth;

    function baguette()
    {
        return "Somebody touch my baguette";
    }
    function loggedIn(){
        # Check apakah ada yang login dan sessionnya tercatat di guard
        if(Auth::guard("web")->check()){
            return true;
        }else{
            return false;
        }
    }
    function activeUser(){
        if(loggedIn() == false){
            return false;
        }else{
            if(Auth::guard("web")->check()){
                # user() untuk mengembalikan object of model yang sedang login sekarang
                return Auth::guard("web")->user();
            }
        }

    }
