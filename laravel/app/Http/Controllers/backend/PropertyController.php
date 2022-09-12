<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\SubCategoryModel;
use App\Models\SecondSubCategoryModel;
use App\Models\PropertyModel;
use App\Models\RandomNumberModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class PropertyController extends Controller
{
    public function showList() {
        $dataList = PropertyModel::leftJoin('categories', 'properties.properties_category_id', 'categories.categories_track_id')
        				->leftJoin('subcategories', 'properties.properties_subcategory_id', 'subcategories.subcategories_track_id')
                        ->orderBy('created_at', 'DESC')
                        ->select('properties.*', 'categories.categories_name', 'subcategories.subcategories_name')->get();
        return view('backend.pages.property.list', compact('dataList'));
    }

    public function add() {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        return view('backend.pages.property.add', compact('categoryList'));
    }

    public function store(Request $request) {
        $data = PropertyModel::where('properties_category_id', $request->properties_category_id)
        		->where('properties_subcategory_id', $request->properties_subcategory_id)
                ->where('properties_name', $request->properties_name)
                ->exists();
        if ($data) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $randomNumber = new RandomNumberModel;
            $trackId = $randomNumber->randomNumber(5, 10) . "OL" . date('YmdHis');
            $data = New PropertyModel();
            $data->properties_name = $request['properties_name'];
            $data->properties_status = $request['properties_status'];
            $data->properties_category_id = $request['second_subcategories_category_id'];
            $data->properties_subcategory_id = $request['second_subcategories_subcategories_id'];
            $data->created_at = Carbon::now();
            $data->properties_track_id = $trackId;
            if ($data->save()) {
                return redirect('portal/property/list')->with('success', 'Information saved successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function edit($id) {
        $data = PropertyModel::where('properties_track_id', $id)->first();
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $subCategoryList = SubCategoryModel::where('subcategories_category_id', $data->properties_category_id)
        	->where('subcategories_status', 'Active')
        	->get();
        return view('backend.pages.property.edit', compact('data', 'categoryList', 'subCategoryList'));
    }

    public function update(Request $request) {
        $id = $request->input('properties_track_id');
        $data = PropertyModel::where('properties_track_id', '!=', $id)
                ->where('properties_category_id', $request->second_subcategories_category_id)
                ->where('properties_subcategory_id', $request->second_subcategories_subcategories_id)
                ->where('properties_name', $request->properties_name)
                ->exists();
        if ($data) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $data = PropertyModel::where('properties_track_id', $id)->first();
            $data->properties_name = $request['properties_name'];
            $data->properties_status = $request['properties_status'];
            $data->properties_category_id = $request['second_subcategories_category_id'];
            $data->properties_subcategory_id = $request['second_subcategories_subcategories_id'];
            if ($data->save()) {
                return redirect('portal/property/list')->with('success', 'Information updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function delete(Request $request) {
        $id = $request->input('properties_track_id');
        PropertyModel::where('properties_track_id', $id)->delete();
        return redirect()->back()->with('success', 'Success :) information deleted.');
    }
}
