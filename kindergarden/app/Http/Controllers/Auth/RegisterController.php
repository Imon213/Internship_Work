<?php

namespace App\Http\Controllers\Auth;
use App\Models\Auth\Registration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;


class RegisterController extends Controller
{
    public function registration(){
        return view('Auth.registration');
    }

    public function register(Request $request){
       {
                    $admin = new  Registration();
                    $admin->email = $request->email;
                    $admin->name = $request->name;
                    $admin->username = $request->username;
                    $admin->password = $request->password;
                    $admin->save();
                    // return redirect()->route('adminTable');
                    
            }
    }
}
