<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DivisionModel;
use App\Models\RandomNumberModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class DivisionController extends Controller
{
    public function showList() {
        $divisionList = DivisionModel::all();
        return view('backend.pages.division.list', compact('divisionList'));
    }

    public function add() {
        return view('backend.pages.division.add');
    }

    public function store(Request $request) {
        $division = DivisionModel::where('division_name', $request->division_name)
            ->where('division_short_name', $request->division_short_name)
                ->exists();
        if ($division) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $randomNumber = new RandomNumberModel;
            $trackId = $randomNumber->randomNumber(5, 10) . "OL" . date('YmdHis');
            $division = New DivisionModel();
            $division->division_name = $request['division_name'];
            $division->division_short_name = $request['division_short_name'];
            $division->division_status = $request['division_status'];
            $division->created_at = Carbon::now();
            $division->division_track_id = $trackId;
            if ($division->save()) {
                return redirect('portal/division/list')->with('success', 'Information saved successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function edit($id) {
        $data = DivisionModel::where('division_track_id', $id)->first();
        return view('backend.pages.division.edit', compact('data'))->with('division_track_id', $id);
    }

    public function update(Request $request) {
        $id = $request->input('division_track_id');
        $division = DivisionModel::where('division_track_id', '!=', $id)
                ->where('division_name',$request->division_name)
                ->where('division_short_name', $request->division_short_name)
                ->exists();
        if ($division) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $division = DivisionModel::where('division_track_id', $id)->first();
            $division->division_name = $request['division_name'];
            $division->division_short_name = $request['division_short_name'];
            $division->division_status = $request['division_status'];
            if ($division->save()) {
                return redirect('portal/division/list')->with('success', 'Information updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function delete(Request $request) {
        $id = $request->input('division_track_id');
        DivisionModel::where('division_track_id', $id)->delete();
        return redirect()->back()->with('success', 'Success :) information deleted.');
    }

}
