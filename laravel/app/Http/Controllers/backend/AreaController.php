<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DivisionModel;
use App\Models\DistrictModel;
use App\Models\AreaModel;
use App\Models\RandomNumberModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class AreaController extends Controller
{
    public function showList() {
        $areaList = AreaModel::leftJoin('divisions', 'areas.areas_division_id', 'divisions.division_track_id')
        				->leftJoin('districts', 'areas.areas_district_id', 'districts.districts_track_id')
                        ->orderBy('areas_id', 'DESC')
                        ->select('areas.*', 'divisions.division_name', 'districts.districts_name')->get();
        return view('backend.pages.area.list', compact('areaList'));
    }

    public function add() {
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        return view('backend.pages.area.add', compact('divisionList'));
    }

    public function store(Request $request) {
        $area = AreaModel::where('areas_division_id',$request->areas_division_id)
        		->where('areas_district_id', $request->areas_district_id)
                ->where('areas_name', $request->areas_name)
                ->exists();
        if ($area) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $randomNumber = new RandomNumberModel;
            $trackId = $randomNumber->randomNumber(5, 10) . "OL" . date('YmdHis');
            $area = New AreaModel();
            $area->areas_name = $request['areas_name'];
            $area->areas_status = $request['areas_status'];
            $area->areas_division_id = $request['areas_division_id'];
            $area->areas_district_id = $request['areas_district_id'];
            $area->created_at = Carbon::now();
            $area->areas_track_id = $trackId;
            if ($area->save()) {
                return redirect('portal/area/list')->with('success', 'Information saved successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function edit($id) {
        $data = AreaModel::where('areas_track_id', $id)->first();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $districtList = DistrictModel::where('districts_division_id', $data->areas_division_id)
        	->where('districts_status', 'Active')
        	->get();
        return view('backend.pages.area.edit', compact('data', 'divisionList', 'districtList'));
    }

    public function update(Request $request) {
        $id = $request->input('areas_track_id');
        $area = AreaModel::where('areas_track_id', '!=', $id)
                ->where('areas_division_id', $request->areas_division_id)
                ->where('areas_district_id', $request->areas_district_id)
                ->where('areas_name', $request->areas_name)
                ->exists();
        if ($area) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $area = AreaModel::where('areas_track_id', $id)->first();
            $area->areas_name = $request['areas_name'];
            $area->areas_status = $request['areas_status'];
            $area->areas_division_id = $request['areas_division_id'];
            $area->areas_district_id = $request['areas_district_id'];
            if ($area->save()) {
                return redirect('portal/area/list')->with('success', 'Information updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function delete(Request $request) {
        $id = $request->input('areas_track_id');
        AreaModel::where('areas_track_id', $id)->delete();
        return redirect()->back()->with('success', 'Success :) information deleted.');
    }

}
