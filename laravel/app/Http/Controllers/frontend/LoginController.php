<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\User;
use App\Models\RandomNumberModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
	//use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
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
        return view('frontend.pages.auth.login');
    }
    
    protected function credentials(Request $request) {
        $field = filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL) ? 'users_email' : 'users_phone';
        $request->merge([$field => $request->input($this->username())]);
        return array_merge($request->only($field, 'password'));
    }
    public function username() {
        return 'email';
    }
    public function authenticate(Request $request) {
        $credentials = $this->credentials($request);
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        } else {
            return redirect()->intended('login')->with('error', 'Invalid login credentials. Check your email address or phone number and password!');
        }
    }

    public function register(Request $request) {
        $users_name =$request->users_name;
        $users_type= $request->users_type;
        $users_email = $request->users_email;
        $users_username=$request->users_username;
        $users_phone =$request->users_phone;
        $password = $request->password;
        $re_password = $request->re_password;

        $checkExistsEmail = User::where('users_email',  $request->users_email)->exists();
		$checkExistsName = User::where('users_username', $request->users_username)->exists();
		$checkExistsPhone = User::where('users_phone',  $request->users_phone)->exists();


        $errors = array();
        /*
         * Checking user name is empty or not
         */
        if (empty($users_name) || $users_name == '') {
            $errors[] = "Full name required";
        }
        if (empty($users_username) || $users_username == '') {
            $errors[] = "User name required";
        }
        /*
         * Check if email address is valid format or not
         */
        if(!empty($users_email)) {
            if (!filter_var($users_email, FILTER_VALIDATE_EMAIL) === true) {
                $errors[] = "Invalid email address format";
            }
        }

        if(!empty( $request->users_email)) {
        	if ($checkExistsEmail) {
		        $errors[] = "An user already exists using provided Email Address";
		    }
	    }

        if ($checkExistsPhone) {
            $errors[] = "An user already exists using provided phone number";
        }
        /*
         * Checking user phone is empty or not
         */
        if (empty($users_phone) || $users_phone == '') {
            $errors[] = "Phone number required. ";
        }
        /*
         * Check password is empty or not
         */
        if (empty($password) || $password == '') {
            $errors[] = "Password required";
        }
        /*
         * Check retype password is empty or not
         */
        if (empty($re_password) || $re_password == '') {
            $errors[] = "Retype your password";
        }
        /*
         * Check if password and confirm password matched or not
         */
        if ($password != $re_password) {
            $errors[] = "Password not matched";
        }
        /*
         * Check password length
         */
        if (strlen($password) > 15) {
            $errors[] = "Password length must be less than 15 character";
        }
        if (count($errors) > 0) {
            return redirect()->back()->withInput()->withErrors($errors)->with('errorArray', 'Array Error Occured');
        } else {
            /*
             * Store users information into database
             */
            $randomNumber = new RandomNumberModel;
            $trackId = $randomNumber->randomNumber(5, 10) . date('YmdHis');
            $obj = new User;
            $obj->users_name = $users_name;
            $obj->users_email = $users_email;
            $obj->users_type= $users_type;
            $obj->users_username = $users_username;
            $obj->users_phone = $users_phone;
            $obj->password = bcrypt($request->password);
            $obj->created_at = Carbon::now();
            $obj->users_track_id = $trackId;
            $obj->users_status = 'Active';
            $obj->save();
            if ($obj->save()) {
                return redirect()->back()->with('success', 'Congratulation, your registration completed successfully');
            }
        }
        
    }

}