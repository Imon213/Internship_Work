<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\RandomNumberModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Storage;

class CategoryController extends Controller
{
    public function showList() {
        $categoryList = CategoryModel::all();
        return view('backend.pages.category.list', compact('categoryList'));
    }

    public function add() {
        return view('backend.pages.category.add');
    }

    public function store(Request $request) {
        $category = CategoryModel::where('categories_name', $request->categories_name)
                ->exists();
        if ($category) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $randomNumber = new RandomNumberModel;
            $trackId = $randomNumber->randomNumber(5, 10) . date('YmdHis');
            $category = New CategoryModel();
            $category->categories_name = $request['categories_name'];
            $category->categories_status = $request['categories_status'];
            $category->created_at = Carbon::now();
            $category->categories_track_id = $trackId;

            $whitelist = array('jpg', 'JPG', 'jpeg', 'gif', 'JPEG', 'png', 'PNG', 'GIF');

            $img_name = $_FILES['categories_picture']['name'];
            
            //process each file
            if (!empty($img_name)) {
                $file =$request->file("categories_picture");
                $rename_img = '';
                $ext = pathinfo($img_name);
                $ext = $ext['extension'];
                if (in_array($ext, $whitelist)) {
                    $rename_img = date('YmdHis') . '.' . $ext;
                } else {
                    return redirect()->back()->with('error', 'The image file must be jpg, jpeg, png, gif format.');
                }
                $category->categories_picture = $rename_img;
                $file->move(('upload/categories_picture/'), $rename_img);
            }

            
            //process each file
            if (!empty($_FILES['categories_icon']['name'])) {
                $file = $request->file("categories_icon");
                $rename_img = '';
                $ext = pathinfo($_FILES['categories_icon']['name']);
                $ext = $ext['extension'];
                if (in_array($ext, $whitelist)) {
                    $rename_img = date('YmdHis') . '.' . $ext;
                } else {
                    return redirect()->back()->with('error', 'The image file must be jpg, jpeg, png, gif format.');
                }
                $category->categories_icon = $rename_img;
                $file->move(('upload/categories_icon/'), $rename_img);
            }

            if ($category->save()) {
                return redirect('portal/category/list')->with('success', 'Information saved successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function edit($id) {
        $data = CategoryModel::where('categories_track_id', $id)->first();
        return view('backend.pages.category.edit', compact('data'));
    }

    public function update(Request $request) {
        $id = $request->input('categories_track_id');
        $category = CategoryModel::where('categories_track_id', '!=', $id)
                ->where('categories_name', $request->categories_name)
                ->exists();
        if ($category) {
            return redirect()->back()->withInput()->with('error', 'Information already exists');
        } else {
            $category = CategoryModel::where('categories_track_id', $id)->first();
            $category->categories_name = $request['categories_name'];
            $category->categories_status = $request['categories_status'];
            $whitelist = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');

            $rename_img = '';
            //process each file
            if (!empty($_FILES['categories_picture']['name'])) {
                $file = $request->file("categories_picture");
                
                $ext = pathinfo($_FILES['categories_picture']['name']);
                $ext = $ext['extension'];
                if (in_array($ext, $whitelist)) {
                    $rename_img = date('YmdHis') . '.' . $ext;
                    if ($category->categories_picture) {
                        $certificateImage = public_path("upload/categories_picture/{$category->categories_picture}"); // get previous image from folder
                        if (File::exists($certificateImage)) { // unlink or remove previous image from folder
                            unlink($certificateImage);
                        }
                    }
                } else {
                    return redirect()->back()->with('error', 'The image file must be jpg, jpeg, png format.');
                }
                $category->categories_picture = $rename_img;
                $file->move(('upload/categories_picture/'), $rename_img);
            } else {
                $rename_img = $category->categories_picture;
                $category->categories_picture = $rename_img;
            }

            
            //process each file
            if (!empty($_FILES['categories_icon']['name'])) {
                $file = $request->file("categories_icon");
                $ext = pathinfo($_FILES['categories_icon']['name']);
                $ext = $ext['extension'];
                if (in_array($ext, $whitelist)) {
                    $rename_img = date('YmdHis') . '.' . $ext;
                    if ($category->categories_icon) {
                        $certificateImage = public_path("upload/categories_icon/{$category->categories_icon}"); // get previous image from folder
                        if (File::exists($certificateImage)) { // unlink or remove previous image from folder
                            unlink($certificateImage);
                        }
                    }
                } else {
                    return redirect()->back()->with('error', 'The image file must be jpg, jpeg, png format.');
                }
                $category->categories_icon = $rename_img;
                $file->move(('upload/categories_icon/'), $rename_img);
            } else {
                $rename_img = $category->categories_picture;
                $category->categories_icon = $rename_img;
            }
            if ($category->save()) {
                return redirect('portal/category/list')->with('success', 'Information updated successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong. please try again.');
            }
        }
    }

    public function delete(Request $request) {
        $id = $request->input('categories_track_id');
        CategoryModel::where('categories_track_id', $id)->delete();
        return redirect()->back()->with('success', 'Success :) information deleted.');
    }
}
