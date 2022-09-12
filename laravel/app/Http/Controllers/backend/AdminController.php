<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\RandomNumberModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller {

    public function showAdminList() {
      $dataList = AdminModel::where('admins_type', 'Super Admin')
      ->where('admins_track_id', '!=', Auth::guard('admin')->user()->admins_track_id)
                ->orderBy('admins_id', 'DESC')
                ->get();
        return view('backend.pages.administrator.listAdmin', compact('dataList'));
    }

    public function addAdmin() {
        return view('backend.pages.administrator.addAdmin');
    }
    public function storeAdmin(Request $request) {
        $admins_name = $request->admins_name;
        $admins_username= $request->admins_username;
        $admins_email = $request->admins_email;
        $admins_mobile= $request->admins_mobile;
        $admins_status = $request->admins_status;
        $password =$request->password;
        $re_password =$request->re_password;

        /*
         * Checking user moble number validation 
         */
        $number = ['011', '015', '016', '017', '018', '019'];
        $mobleNumber = str_split($admins_mobile, 3);
        $mobleNumber[0];

        $errors = array();

        if (empty($admins_name) || $admins_name == '') {
            $errors[] = "Name required";
        }

        /*
         * Checking user phone is empty or not
         */
        if (empty($admins_mobile) || $admins_mobile== '') {
            $errors[] = "Mobile Number required";
        }
        /*
         * Checking user phone number digit length 11 character or not
         */
        if (!empty($admins_mobile)) {
            if (strlen($admins_mobile) != 11) {
                $errors[] = "Phone number must be 11 digit";
            }

            if (!is_numeric($admins_mobile)) {
                $errors[] = "Phone number must be numeric value";
            }

            if (!in_array($mobleNumber[0], $number)) {
                $errors[] = "Phone number is not matched";
            }

            $checkExists = AdminModel::where('admins_mobile', $request->admins_mobile)->exists();
            if ($checkExists) {
                $errors[] = "Phone number already is in our database";
            }
        }
        if (empty($admins_email) || $admins_email == '') {
            $errors[] = "Email required";
        }
        if (empty($admins_username) || $admins_username== '') {
            $errors[] = "Username required";
        }

        if (!empty($request->admins_email)) {
            if (!filter_var($request->admins_email, FILTER_VALIDATE_EMAIL) === true) {
                $errors[] = "Email is not correct";
            } else {
                $checkExistsEmail = AdminModel::where('admins_email', $request->admins_email)->exists();
                if ($checkExistsEmail) {
                    $errors[] = "Email is already in our database";
                }
            }
        }
        if (empty($admins_status) || $admins_status == '') {
            $errors[] = "Status required";
        }
        if (empty($password) || $password == '') {
            $errors[] = "Password required";
        }
        if (empty($re_password) || $re_password == '') {
            $errors[] = "Re password required";
        }

        if ($password != $re_password) {
            $errors[] = "Password is not matched";
        }

        if (strlen($password) < 6) {
            $errors[] = "Password must be greater than 5 character";
        }

        if (strlen($password) > 15) {
            $errors[] = "Password must be less than 15 character";
        }

        if (count($errors) > 0) {
            return redirect()->back()->withInput()->withErrors($errors)->with('errorArray', 'Array Error Occured');
        } else {
            /*
             * Store D.C information into database
             */
            $randomNumber = new RandomNumberModel;
            $trackId = $randomNumber->randomNumber(5, 10) . "OL" . date('YmdHis');
            $obj = new AdminModel;
            $obj->admins_name = $admins_name;
            $obj->admins_email = $admins_email;
            $obj->admins_mobile= $admins_mobile;
            $obj->admins_username= $admins_username;
            $obj->admins_status = $admins_status;
            $obj->admins_type = 'Super Admin';
            $obj->admins_track_id = $trackId;
            $obj->password = bcrypt($password);
            $obj->created_at = Carbon::now();

            if ($obj->save()) {
                    return redirect('portal/admin/list')->with('success', 'Admin successfully added');
            } else {
                return redirect()->back()->with('error', 'Something went wrong.');
            }
        }
    }

    public function activate($id) {
        $dataList = User::where('admins_track_id', $id)->first();
        $dataList->admins_status = "Active";
        if ($dataList->save()) {
            
                return redirect()->back()->with('success', 'একাউন্ট সক্রিয় করণ সফল হয়েছে ।');
        }
    }

    public function inActivate(Request $request) {
        $id = $request['admins_track_id'];
        $dataList = User::where('admins_track_id', $id)->first();
        $dataList->admins_status = "Inactive";
        $dataList->admins_rejection_note = $request->admins_rejection_note;
        if (!empty($request->admins_rejection_note)) {
            if ($dataList->save()) {
                
                    return redirect()->back()->with('success', 'একাউন্ট নিষ্ক্রিয় করণ সফল হয়েছে ।');
            }
        } else {
            return redirect()->back()->with('error', 'নিষ্ক্রিয় করণের বিবরণ আবশ্যক ।');
        }
    }

}