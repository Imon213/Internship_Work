<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use App\Models\DivisionModel;
use App\Models\ProductModel;
use App\Models\DistrictModel;
use App\Models\AreaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {

    public function getProfile() {
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $districtList = DistrictModel::where('districts_division_id', Auth::user()->users_division_id)->get();
        $areaList = AreaModel::where('areas_district_id', Auth::user()->users_district_id)->get();
        return view('frontend.pages.profile.profile', compact('divisionList', 'districtList', 'areaList'));
    }

    public function profileUpdate(Request $request) {

        $users_name = $request->users_name;
        $users_email =  $request->users_email;
        $users_username = $request->users_username;
        $users_phone =  $request->users_phone;
        $users_division_id =  $request->products_division_id;
        $users_district_id = $request->products_district_id;
        $users_area_id =  $request->products_area_id;

        if (!empty( $request->users_email)) {
            if (!filter_var( $request->users_email, FILTER_VALIDATE_EMAIL) === true) {
                $errors[] = "Email is not valid";
            } else {
                $checkExistsEmail = User::where('users_track_id', '!=', Auth::user()->users_track_id)
                        ->where('users_email',  $request->users_email)
                        ->exists();
                if ($checkExistsEmail) {
                    $errors[] = "An user already exists using provided Email Address";
                }
            }
        }
        $checkExistsName = User::where('users_track_id', '!=', Auth::user()->users_track_id)
                ->where('users_username',  $request->users_username)
                ->exists();
        $checkExistsPhone = User::where('users_track_id', '!=', Auth::user()->users_track_id)
                ->where('users_phone',  $request->users_phone)
                ->exists();


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
        if (count($errors) > 0) {
            return redirect()->back()->withInput()->withErrors($errors)->with('errorArray', 'Array Error Occured');
        } else {
            $obj = Auth::user();
            $obj->users_name = $users_name;
            $obj->users_email = $users_email;
            $obj->users_username = $users_username;
            $obj->users_division_id = $users_division_id;
            $obj->users_district_id = $users_district_id;
            $obj->users_phone = $users_phone;
            $obj->users_area_id = $users_area_id;
            $obj->save();
            if ($obj->save()) {
                return redirect()->back()->with('success', 'Congratulation, profile updated successfully');
            }
        }
    }

    public function updatePassword(Request $request) {
        $user = Auth::user();
        if (empty($request->get('current_password')) || $request->get('current_password') == '') {
            return redirect()->back()->withInput()->with('error', "Current password required");
        }
        if (empty($request->get('password')) || $request->get('password') == '') {
            return redirect()->back()->withInput()->with('error', 'password required');
        }
        if (empty($request->get('confirm_password')) || $request->get('confirm_password') == '') {
            return redirect()->back()->withInput()->with('error', 'Retype password required');
        }
        if (Hash::check($request->get('current_password'), $user->password)) {
            if ($request->password !== $request->confirm_password) {
                return redirect()->back()->withInput()->with('error', 'Password Mismatch!!');
            } else if (Hash::check($request->get('password'), $user->password)) {
                return redirect()->back()->withInput()->with('error', 'Sorry, this password is already been used. Please input new one.');
            } else {
                $user->password = bcrypt($request->password);
                if ($user->save()) {
                    return redirect()->back()->with('success', 'Password changed successfully.');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Current password does not match.');
        }
    }

}
