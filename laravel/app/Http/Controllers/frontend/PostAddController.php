<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\SecondSubCategoryModel;
use App\Models\DivisionModel;
use App\Models\ProductModel;
use App\Models\PropertyModel;
use App\Models\ProductImageModel;
use App\Models\RandomNumberModel;
use Carbon\Carbon;
use File;
use Storage;
use Image;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Auth;

class PostAddController extends Controller
{
	public function category() {
		$categoryList = CategoryModel::where('categories_status', 'Active')->get();
    	return view ('frontend.pages.postAdd.cats', compact('categoryList'));
	}

	public function postAdd($catId, $id) {
		$dataList = SecondSubCategoryModel::where('second_subcategories_status', 'Active')
			->where('second_subcategories_category_id', $catId)
			->where('second_subcategories_subcategories_id', $id)
			->get();
		$featureList = PropertyModel::where('properties_category_id', $catId)
			->where('properties_subcategory_id', $id)
			->get();
		$divisionList = DivisionModel::where('division_status', 'Active')->get();
		return view ('frontend.pages.postAdd.add', compact('divisionList', 'dataList', 'featureList'))->with('products_category_id', $catId)->with('products_subcategory_id', $id);
	}

	public function postAddStore(Request $request) {
		$userList = User::where('users_track_id', $request->input('products_users_id'))->first();
		$dataList = new ProductModel;
        $randomNumber = new RandomNumberModel;
        $trackId = $randomNumber->randomNumber(5, 10) . "OL" . date('YmdHis');
		 if (!empty($request->input('products_property_id'))) {
            $dataList->products_property_id = implode(",", $request->input('products_property_id'));
        } else {
            $dataList->products_property_id = '';
        }
        $dataList->products_name = $request->input('products_name');
        $dataList->products_second_subcategory_id = $request->input('products_second_subcategory_id');
        $dataList->products_category_id = $request->input('products_category_id');
        $dataList->products_subcategory_id = $request->input('products_subcategory_id');
        //$dataList->users_type= $request->input('users_type');
        $dataList->products_division_id = $request->input('products_division_id');
        $dataList->products_district_id = $request->input('products_district_id');
        $dataList->products_area_id = $request->input('products_area_id');
        $dataList->products_description = $request->input('products_description');
        $dataList->products_quantity = $request->input('products_quantity');
        $dataList->products_type = $request->input('products_type');
        $dataList->products_price = $request->input('products_price');
        $dataList->products_negotiable = $request->input('products_negotiable');        
        $dataList->products_mobile_no = $userList->users_phone;
        $dataList->products_users_id = $userList->users_track_id;
        $dataList->products_status = 'Inactive';
        $dataList->products_track_id = $trackId;

        if(!empty($request->input('products_discount_price'))) {
        	$dataList->products_discount = 'Yes';
        	$dataList->products_discount_price = $request->input('products_discount_price');
        }


		if($dataList->save()) {
            if(!empty($request->file('products_main_picture'))) {
                $img_name = $_FILES['products_main_picture']['name'];
                $i = 0;
                
                if (count($_FILES['products_main_picture']['name']) <= 20) {
                    foreach ($request->file('products_main_picture') as $file) {
                    	$ext = pathinfo($img_name[$i]);
                        $ext = $ext['extension'];
                        
                    	$allowed = array('jpeg', 'png', 'jpg', 'JPG', 'PNG');
                    	
                    	if (!in_array($ext, $allowed)) {
                                return redirect()->back()->with('error', 'Picture must be PNG, JPG format.');
                            } else {
                        //process each file
                        
                        $rename_img = $i . date('YmdHis') . '.' . $ext;
                        $imageList = new ProductImageModel;
                        $imageList->product_image_picture = $rename_img;
                        $imageList->product_image_track_id = $trackId;
                        $imageList->save();
                        $file->move(('upload/products_image_picture'), $rename_img);
                        $i++;
                        }
                    }
                }
                return redirect('myAdd')->with('success', 'Your add has been successfully added. Your add has been reviewed by our team. After successfully reviewed your add will be published.');     
            } else {
                return redirect()->back()->with('error', 'Your add has not been added');
            }
		} else {
			return redirect()->back()->with('error', 'Your add has not been added');
		}
	}

	public function myAdd() {
		$dataList = ProductModel::leftJoin('users', 'products.products_users_id', 'users.users_track_id')
            ->leftJoin('divisions', 'products.products_division_id', 'divisions.division_track_id')
            ->leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
            ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
            ->leftJoin('categories', 'products.products_category_id', 'categories.categories_track_id')
            ->leftJoin('subcategories', 'products.products_subcategory_id', 'subcategories.subcategories_track_id')            
            ->leftJoin('second_subcategories', 'products.products_second_subcategory_id', 'second_subcategories.second_subcategories_track_id')
			->where('products_users_id', Auth::user()->users_track_id)
			->select('products.*', 'users.users_name', 'users.users_phone', 'divisions.division_name', 'districts.districts_name', 'areas.areas_name', 'categories.categories_name', 'subcategories.subcategories_name', 'second_subcategories.second_subcategories_name')
			->get();
    	return view ('frontend.pages.postAdd.myAdd', compact('dataList'));
	}
}