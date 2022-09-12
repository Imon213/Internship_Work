<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DivisionModel;
use App\Models\DistrictModel;
use App\Models\RandomNumberModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class DistrictController extends Controller
{
    public function showList() {
        $districtList = DistrictModel::leftJoin('divisions', 'districts.districts_division_id', 'divisions.division_track_id')
                        ->orderBy('districts_id', 'DESC')
                        ->select('districts.*', 'divisions.division_name')->get();
        return view('backend.pages.district.list', compact('districtList'));
    }

    public function add() {
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        return view('backend.pages.district.add', compact('divisionList'));
    }

    public function store(Request $request) {
        $district = DistrictModel::where('districts_division_id', $request->districts_division_id)
                ->where('districts_name', $request->districts_name)
                ->where('districts_short_name',$request->districts_short_name)
                ->exists();
        if ($district) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $randomNumber = new RandomNumberModel;
            $trackId = $randomNumber->randomNumber(5, 10) . "OL" . date('YmdHis');
            $district = New DistrictModel();
            $district->districts_name = $request['districts_name'];
            $district->districts_short_name = $request['districts_short_name'];
            $district->districts_status = $request['districts_status'];
            $district->districts_division_id = $request['districts_division_id'];
            $district->created_at = Carbon::now();
            $district->districts_track_id = $trackId;
            if ($district->save()) {
                return redirect('portal/district/list')->with('success', 'Information saved successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function edit($id) {
        $data = DistrictModel::where('districts_track_id', $id)->first();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        return view('backend.pages.district.edit', compact('data', 'divisionList'))->with('districts_track_id', $id);
    }

    public function update(Request $request) {
        $id = $request->input('districts_track_id');
        $thana = DistrictModel::where('districts_track_id', '!=', $id)
                ->where('districts_division_id', $request->districts_division_id)
                ->where('districts_name', $request->districts_name)
                ->where('districts_short_name', $request->districts_short_name)
                ->exists();
        if ($thana) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $district = DistrictModel::where('districts_track_id', $id)->first();
            $district->districts_name = $request['districts_name'];
            $district->districts_short_name = $request['districts_short_name'];
            $district->districts_status = $request['districts_status'];
            $district->districts_division_id = $request['districts_division_id'];
            if ($district->save()) {
                return redirect('portal/district/list')->with('success', 'Information updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function delete(Request $request) {
        $id = $request->input('districts_track_id');
        DistrictModel::where('districts_track_id', $id)->delete();
        return redirect()->back()->with('success', 'Success :) information deleted.');
    }

}
