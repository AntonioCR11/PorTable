<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Migrasi\userMigrasi;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verify($token)
    {
        $selectedUser = userMigrasi::where('id',$token)->first();
        if($selectedUser->verified_at == null){
            $selectedUser->verified_at = now();
            $selectedUser->save();
        }
        else{

        }
        return redirect('index');
    }
}
