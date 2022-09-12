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

class MyAddController extends Controller
{
    public function getAdd($id) {
		$dataList = ProductModel::where('products_track_id', $id)->first();
		$secondCategoryList = SecondSubCategoryModel::where('second_subcategories_status', 'Active')
			->where('second_subcategories_category_id', $dataList->products_category_id)
			->where('second_subcategories_subcategories_id', $dataList->products_subcategory_id)
			->get();
		$featureList = PropertyModel::where('properties_category_id', $dataList->products_category_id)
			->where('properties_subcategory_id', $dataList->products_subcategory_id)
			->get();
		$divisionList = DivisionModel::where('division_status', 'Active')->get();
		$bedList = '';

		if(!empty($dataList->products_property_id)) {
			$bedList = explode(",", $dataList->products_property_id);
			foreach ($bedList as $bed) {
		                $bed_type = PropertyModel::where('properties_id', $bed)->first();
		         }
		}
		
		$imageList = ProductImageModel::where('product_image_track_id', $id)->get();

		return view ('frontend.pages.postAdd.editAdd', compact('divisionList', 'dataList', 'imageList', 'featureList', 'secondCategoryList', 'bedList', 'bed_type'))->with('products_track_id', $id);
	}

	public function addUpdate(Request $request) {
		$userList = User::where('users_track_id', $request->input('products_users_id'))->first();
		$dataList = ProductModel::where('products_track_id', $request->input('products_track_id'))->first();
		 if (!empty($request->input('products_property_id'))) {
            $dataList->products_property_id = implode(",", $request->input('products_property_id'));
        } else {
            $dataList->products_property_id = '';
        }
        $dataList->products_name = $request->input('products_name');
        $dataList->products_second_subcategory_id = $request->input('products_second_subcategory_id');
        $dataList->products_description = $request->input('products_description');
        $dataList->products_type = $request->input('products_type');
        $dataList->products_price = $request->input('products_price');
        $dataList->products_negotiable = $request->input('products_negotiable');        

		if($dataList->save()) {
            if(!empty($request->file("products_main_picture"))) {
                $img_name = $_FILES['products_main_picture']['name'];
                $i = 0;
                if (count($_FILES['products_main_picture']['name']) <= 20) {
                    foreach ($request->file("products_main_picture") as $file) {
                        //process each file
                        $ext = pathinfo($img_name[$i]);
                        $ext = $ext['extension'];
                        $allowed = array('jpeg', 'png', 'jpg', 'JPG', 'PNG');
                    	
                    	if (!in_array($ext, $allowed)) {
                                return redirect()->back()->with('error', 'Picture must be PNG, JPG format.');
                            } else {
                        $rename_img = $i . date('YmdHis') . '.' . $ext;
                        $imageList = new ProductImageModel;
                        $imageList->product_image_picture = $rename_img;
                        $imageList->product_image_track_id = $dataList->products_track_id;
                        $imageList->save();
                        $file->move(('upload/products_image_picture'), $rename_img);
                        $i++;
                        }
                    }
                }
                return redirect('myAdd')->with('success', 'Your add has been successfully updated.');     
            } else {
                return redirect()->back()->with('error', 'Your add has not been added');
            }
		} else {
			return redirect()->back()->with('error', 'Your add has not been added');
		}
	}

	public function delete(Request $request) {
        $id = $request->input('products_track_id');
        ProductModel::where('products_track_id', $id)->delete();
        $product_image = ProductImageModel::where('product_image_track_id', $id)->get();

        if(count($product_image) > 0) {
        	foreach($product_image as $product) {
	        	$product_image_picture = public_path("upload/product_image/{$product->product_image_picture}");

		        if (File::exists($product_image_picture)) {
		            unlink($product_image_picture);
		        }
		        ProductImageModel::where('product_image_track_id', $id)->delete();
	        }
        }
        
        
        return redirect()->back()->with('success', 'Success :) information deleted');
    }
    public function imageDelete(Request $request) {
        $id = $request->input('product_image_id');
        $product_image = ProductImageModel::where('product_image_id', $id)->first();

        if(count($product_image) > 0) {
        	
	        	$product_image_picture = public_path("upload/product_image/{$product_image->product_image_picture}");

		        if (File::exists($product_image_picture)) {
		            unlink($product_image_picture);
		        }
		        ProductImageModel::where('product_image_id', $id)->delete();
        }
        
        
        return redirect()->back()->with('success', 'Success :) image deleted');
    }
}
