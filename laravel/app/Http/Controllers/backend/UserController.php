<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Moels\User;
use App\Models\DivisionModel;
use App\Models\RandomNumberModel;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class UserController extends Controller
{
    public function showList() {
        $dataList = User::all();
        return view('backend.pages.user.list', compact('dataList'));
    }

    public function activate(Request $request) {
    	$id = $request->input('users_track_id');
        $dataList = User::where('users_track_id', $id)->first();
        $dataList->users_status = 'Active';
        if($dataList->save()) {
        	return redirect()->back()->with('success', 'User Activated');
        }
    }
    public function inActivate(Request $request) {
    	$id = $request->input('users_track_id');
        $dataList = User::where('users_track_id', $id)->first();
        $dataList->users_status = 'Inactive';
        if($dataList->save()) {
        	return redirect()->back()->with('success', 'User Inactivated');
        }
    }

    public function add()  {
    	$divisionList = DivisionModel::where('division_status', 'Active')->get();
    	return view('backend.pages.user.add', compact('divisionList'));
    }

    public function store(Request $request) {
        $users_name = $request->users_name;
        $users_email = $request->users_email;
        $users_username=$request->users_username;
        $users_phone = $request->users_phone;
        $password = $request->password;
        $re_password = $request->re_password;
        $users_division_id = $request->areas_division_id;
        $users_district_id = $request->areas_district_id;
        $users_area_id = $request->users_area_id;
        $users_status = $request->users_status;

        $checkExistsEmail = User::where('users_email', $request->users_email)->exists();
		$checkExistsName = User::where('users_username', $request->users_username)->exists();
		$checkExistsPhone = User::where('users_phone',$request->users_phone)->exists();


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
        if (empty($users_division_id) || $users_division_id == '') {
            $errors[] = "Division name required";
        }
        if (empty($users_district_id) || $users_district_id == '') {
            $errors[] = "District name required";
        }
        if (empty($users_status) || $users_status == '') {
            $errors[] = "Status required";
        }
        /*
         * Check if email address is valid format or not
         */
        if(!empty($users_email)) {
            if (!filter_var($users_email, FILTER_VALIDATE_EMAIL) === true) {
                $errors[] = "Invalid email address format";
            }
        }

        if(!empty($request->email)) {
        	if ($checkExistsEmail) {
		        $errors[] = "An user already exists using provided Email Address";
		    }
	    }

        if ($checkExistsName) {
            $errors[] = "An user already exists using provided Username";
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
            $obj->users_username = $users_username;
            $obj->users_division_id = $users_division_id;
            $obj->users_district_id = $users_district_id;
            $obj->users_phone = $users_phone;
            $obj->users_area_id = $users_area_id;
            $obj->password = bcrypt($request->password);
            $obj->created_at = Carbon::now();
            $obj->users_track_id = $trackId;
            $obj->users_status = $users_status;
            $obj->save();
            if ($obj->save()) {
                return redirect('portal/user/list')->with('success', 'Congratulation, User added successfully');
            }
        }
        
    }

    public function details($id) {
        $dataList = User::leftJoin('divisions', 'users.users_division_id', 'divisions.division_track_id')
                ->leftJoin('districts', 'users.users_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'users.users_area_id', 'areas.areas_track_id')
                ->where('users.users_track_id', $id)
                ->first();
        return view('backend.pages.user.details', compact('dataList'));
    }
}
