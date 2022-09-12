<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\AdminModelOL;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Carbon\Carbon;

class LoginController extends Controller {

//use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/portal/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login() {
        return view('backend.auth.login');
    }

    protected function credentials(Request $request) {
        $field = filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL) ? 'admins_email' : 'admins_mobile';
        $request->merge([$field => $request->input($this->username())]);
        return array_merge($request->only($field, 'password'), ['admins_status' => 'Active']);
    }

    public function username() {
        return 'admins_email';
    }

    public function authenticate(Request $request) {
        $credentials = $this->credentials($request);
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('portal/dashboard');
        } else {
            return redirect()->intended('portal/login')
                            ->withInput($request->except('admins_password'))
                            ->with('error', 'Invalid login credentials. Check email address or mobile number and password or your account is not active yet!');
        }
    }

    public function getLogout() {
        Auth::guard('admin')->logout();
        return redirect()->intended('portal/login');
    }

}