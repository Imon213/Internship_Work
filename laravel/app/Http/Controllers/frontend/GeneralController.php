<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use App\Models\DistrictModel;
use App\Models\PropertyModel;

class GeneralController extends Controller
{
	public function getDistrict(Request $request) {
        $products_division_id = $_POST['products_division_id'];

        $dataList = DistrictModel::where('districts_division_id', $products_division_id)->get();
        $response = array('output' => 'success', 'msg' => 'data found', 'dataList' => $dataList);
        return response()->json($response);
    }

	public function getArea(Request $request) {
        $products_district_id = $_POST['products_district_id'];

        $areaList = AreaModel::all()->where('areas_district_id', $products_district_id);
        $response = array('output' => 'success', 'msg' => 'data found', 'areaList' => $areaList);
        return response()->json($response);
    }

    public function getProperty(Request $request) {
        $products_second_subcategory_id = $_POST['products_second_subcategory_id'];

        $propertyList = PropertyModel::where('properties_second_subcategory_id', $products_second_subcategory_id)->get();
        $response = array('output' => 'success', 'msg' => 'data found', 'propertyList' => $propertyList);
        return response()->json($response);
    }

}