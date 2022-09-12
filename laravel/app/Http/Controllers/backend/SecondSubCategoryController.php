<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\SubCategoryModel;
use App\Models\SecondSubCategoryModel;
use App\Models\RandomNumberModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class SecondSubcategoryController extends Controller
{
    public function showList() {
        $dataList = SecondSubCategoryModel::leftJoin('categories', 'second_subcategories.second_subcategories_category_id', 'categories.categories_track_id')
        				->leftJoin('subcategories', 'second_subcategories.second_subcategories_subcategories_id', 'subcategories.subcategories_track_id')
                        ->orderBy('created_at', 'DESC')
                        ->select('second_subcategories.*', 'categories.categories_name', 'subcategories.subcategories_name')->get();
        return view('backend.pages.secondSubCategory.list', compact('dataList'));
    }

    public function add() {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        return view('backend.pages.secondSubCategory.add', compact('categoryList'));
    }

    public function store(Request $request) {
        $data = SecondSubCategoryModel::where('second_subcategories_category_id',$request->second_subcategories_category_id)
        		->where('second_subcategories_subcategories_id', $request->second_subcategories_subcategories_id)
                ->where('second_subcategories_name',$request->second_subcategories_name)
                ->exists();
        if ($data) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $randomNumber = new RandomNumberModel;
            $trackId = $randomNumber->randomNumber(5, 10) . "OL" . date('YmdHis');
            $data = New SecondSubCategoryModel();
            $data->second_subcategories_name = $request['second_subcategories_name'];
            $data->second_subcategories_status = $request['second_subcategories_status'];
            $data->second_subcategories_category_id = $request['second_subcategories_category_id'];
            $data->second_subcategories_subcategories_id = $request['second_subcategories_subcategories_id'];
            $data->created_at = Carbon::now();
            $data->second_subcategories_track_id = $trackId;
            if ($data->save()) {
                return redirect('portal/secondSubCategory/list')->with('success', 'Information saved successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function edit($id) {
        $data = SecondSubCategoryModel::where('second_subcategories_track_id', $id)->first();
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $subCategoryList = SubCategoryModel::where('subcategories_category_id', $data->second_subcategories_category_id)
        	->where('subcategories_status', 'Active')
        	->get();
        return view('backend.pages.secondSubCategory.edit', compact('data', 'categoryList', 'subCategoryList'));
    }

    public function update(Request $request) {
        $id = $request->input('second_subcategories_track_id');
        $area = SecondSubCategoryModel::where('second_subcategories_track_id', '!=', $id)
                ->where('second_subcategories_category_id', $request->second_subcategories_category_id)
                ->where('second_subcategories_subcategories_id', $request->second_subcategories_subcategories_id)
                ->where('second_subcategories_name', $request->second_subcategories_name)
                ->exists();
        if ($area) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $area = SecondSubCategoryModel::where('second_subcategories_track_id', $id)->first();
            $area->second_subcategories_name = $request['second_subcategories_name'];
            $area->second_subcategories_status = $request['second_subcategories_status'];
            $area->second_subcategories_category_id = $request['second_subcategories_category_id'];
            $area->second_subcategories_subcategories_id = $request['second_subcategories_subcategories_id'];
            if ($area->save()) {
                return redirect('portal/secondSubCategory/list')->with('success', 'Information updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function delete(Request $request) {
        $id = $request->input('second_subcategories_track_id');
        SecondSubCategoryModel::where('second_subcategories_track_id', $id)->delete();
        return redirect()->back()->with('success', 'Success :) information deleted.');
    }
}
