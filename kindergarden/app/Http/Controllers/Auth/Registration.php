<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Registration extends Controller
{
    public function Registration()
    {
        return view('Auth.Registration');
    }
}
