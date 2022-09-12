<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\SubCategoryModel;
use App\Models\RandomNumberModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Storage;

class SubCategoryController extends Controller
{
    public function showList() {
        $dataList = SubCategoryModel::leftJoin('categories', 'subcategories.subcategories_category_id', 'categories.categories_track_id')
                        ->orderBy('subcategories_id', 'DESC')
                        ->select('subcategories.*', 'categories.categories_name')
                        ->orderBy('created_at', 'DESC')->get(); 
        return view('backend.pages.subCategory.list', compact('dataList'));
    }

    public function add() {
        $dataList = CategoryModel::where('categories_status', 'Active')->get();
        return view('backend.pages.subCategory.add', compact('dataList'));
    }

    public function store(Request $request) {
        $data = SubCategoryModel::where('subcategories_category_id', Input::get('subcategories_category_id'))
                ->where('subcategories_name', Input::get('subcategories_name'))
                ->exists();
        if ($data) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $randomNumber = new RandomNumberModel;
            $trackId = $randomNumber->randomNumber(5, 10) . "OL" . date('YmdHis');
            $data = New SubCategoryModel();
            $data->subcategories_name = $request['subcategories_name'];
            $data->subcategories_status = $request['subcategories_status'];
            $data->subcategories_category_id = $request['subcategories_category_id'];
            $data->created_at = Carbon::now();
            $data->subcategories_track_id = $trackId;

            $whitelist = array('jpg', 'JPG', 'jpeg', 'gif', 'JPEG', 'png', 'PNG', 'GIF');

            $img_name = $_FILES['subcategories_icon']['name'];
            
            //process each file
            if (!empty($img_name)) {
                $file = $request->file("subcategories_icon");
                $rename_img = '';
                $ext = pathinfo($img_name);
                $ext = $ext['extension'];
                if (in_array($ext, $whitelist)) {
                    $rename_img = date('YmdHis') . '.' . $ext;
                } else {
                    return redirect()->back()->with('error', 'The image file must be jpg, jpeg, png, gif format.');
                }
                $data->subcategories_icon = $rename_img;
                $file->move(('upload/subcategories_icon/'), $rename_img);
            }

            if ($data->save()) {
                return redirect('portal/subCategory/list')->with('success', 'Information saved successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function edit($id) {
        $data = SubCategoryModel::where('subcategories_track_id', $id)->first();
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        return view('backend.pages.subCategory.edit', compact('data', 'categoryList'));
    }

    public function update(Request $request) {
        $id = $request->input('subcategories_track_id');
        $data = SubCategoryModel::where('subcategories_track_id', '!=', $id)
                ->where('subcategories_category_id',$request->get('subcategories_category_id'))
                ->where('subcategories_name', $request->get('subcategories_name'))
                ->exists();
        if ($data) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $data = SubCategoryModel::where('subcategories_track_id', $id)->first();
            $data->subcategories_name = $request['subcategories_name'];
            $data->subcategories_status = $request['subcategories_status'];
            $data->subcategories_category_id = $request['subcategories_category_id'];

            $whitelist = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');

            $rename_img = '';
            //process each file
            if (!empty($_FILES['subcategories_icon']['name'])) {
                $file = $request->file("subcategories_icon");                
                $ext = pathinfo($_FILES['subcategories_icon']['name']);
                $ext = $ext['extension'];
                if (in_array($ext, $whitelist)) {
                    $rename_img = date('YmdHis') . '.' . $ext;
                    if ($data->subcategories_icon) {
                        $certificateImage = public_path("upload/subcategories_icon/{$data->subcategories_icon}"); // get previous image from folder
                        if (File::exists($certificateImage)) { // unlink or remove previous image from folder
                            unlink($certificateImage);
                        }
                    }
                } else {
                    return redirect()->back()->with('error', 'The image file must be jpg, jpeg, png format.');
                }
                $data->subcategories_icon = $rename_img;
                $file->move(('upload/subcategories_icon/'), $rename_img);
            } else {
                $rename_img = $data->subcategories_icon;
                $data->subcategories_icon = $rename_img;
            }


            if ($data->save()) {
                return redirect('portal/subCategory/list')->with('success', 'Information updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function delete(Request $request) {
        $id = $request->input('subcategories_track_id');
        SubCategoryModel::where('subcategories_track_id', $id)->delete();
        return redirect()->back()->with('success', 'Success :) information deleted.');
    }

}
