<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DistrictModel;
use App\Models\SubCategoryModel;
use App\Models\SecondSubCategoryModel;
use App\Models\AreaModel;

class DashboardController extends Controller
{
    public function dashboard() {
    	return view('backend.pages.dashboard.index');
    }

    public function pagenotfound() {
        return view('errors.503');
    }

    public function getDistrictBackend(Request $request) {
        $areas_division_id = $_POST['areas_division_id'];

        $districtList = DistrictModel::all()->where('districts_division_id', $areas_division_id);
        $response = array('output' => 'success', 'msg' => 'data found', 'districtList' => $districtList);
        return response()->json($response);
    }

    public function getAreaBackend(Request $request) {
        $areas_district_id = $_POST['areas_district_id'];

        $areaList = AreaModel::all()->where('areas_district_id', $areas_district_id);
        $response = array('output' => 'success', 'msg' => 'data found', 'areaList' => $areaList);
        return response()->json($response);
    }

    public function getSubCategoryBackend(Request $request) {
        $second_subcategories_category_id = $_POST['second_subcategories_category_id'];

        $dataList = SubCategoryModel::all()->where('subcategories_category_id', $second_subcategories_category_id);
        $response = array('output' => 'success', 'msg' => 'data found', 'dataList' => $dataList);
        return response()->json($response);
    }

    public function getSecondSubCategoryBackend(Request $request) {
        $second_subcategories_subcategories_id = $_POST['second_subcategories_subcategories_id'];

        $dataList = SecondSubCategoryModel::all()->where('second_subcategories_subcategories_id', $second_subcategories_subcategories_id);
        $response = array('output' => 'success', 'msg' => 'data found', 'dataList' => $dataList);
        return response()->json($response);
    }
}
