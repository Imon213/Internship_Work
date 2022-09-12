<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DivisionModel;
use App\Models\DistrictModel;
use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\RandomNumberModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AdsController extends Controller
{
	public function showPublishList() {
        $dataList = ProductModel::leftJoin('categories', 'products.products_category_id', 'categories.categories_track_id')
            ->leftJoin('subcategories', 'products.products_subcategory_id', 'subcategories.subcategories_track_id')            
            ->leftJoin('second_subcategories', 'products.products_second_subcategory_id', 'second_subcategories.second_subcategories_track_id')
            ->leftJoin('divisions', 'products.products_division_id', 'divisions.division_track_id')
            ->leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
            ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
			->leftJoin('users', 'products.products_users_id', 'users.users_track_id')
        	->where('products.products_status', 'Active')
        	->select('products.*', 'users.users_name', 'divisions.division_name', 'districts.districts_name', 'areas.areas_name', 'categories.categories_name', 'subcategories.subcategories_name', 'second_subcategories.second_subcategories_name')
        	->get();
        return view('backend.pages.ads.publish', compact('dataList'));
    }

	public function showUnpublishList() {
        $dataList = ProductModel::leftJoin('categories', 'products.products_category_id', 'categories.categories_track_id')
            ->leftJoin('subcategories', 'products.products_subcategory_id', 'subcategories.subcategories_track_id')            
            ->leftJoin('second_subcategories', 'products.products_second_subcategory_id', 'second_subcategories.second_subcategories_track_id')
            ->leftJoin('divisions', 'products.products_division_id', 'divisions.division_track_id')
            ->leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
            ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
			->leftJoin('users', 'products.products_users_id', 'users.users_track_id')
        	->where('products.products_status', 'Inactive')
        	->select('products.*', 'users.users_name', 'divisions.division_name', 'districts.districts_name', 'areas.areas_name', 'categories.categories_name', 'subcategories.subcategories_name', 'second_subcategories.second_subcategories_name')
        	->get();
        return view('backend.pages.ads.unpublish', compact('dataList'));
    }
    public function showImageList($id) {
        $dataList = ProductImageModel::where('product_image.product_image_track_id', $id)
        	->get();
        return view('backend.pages.ads.image', compact('dataList'));
    }

    public function activate(Request $request) {
    	$id = $request->input('products_track_id');
        $dataList = ProductModel::where('products_track_id', $id)->first();
        $dataList->products_status = 'Active';
        if($dataList->save()) {
        	return redirect()->back()->with('success', 'Ads Activated');
        }
    }
    public function inActivate(Request $request) {
    	$id = $request->input('products_track_id');
        $dataList = ProductModel::where('products_track_id', $id)->first();
        $dataList->products_status = 'Inactive';
        if($dataList->save()) {
        	return redirect()->back()->with('success', 'Ads Inactivated');
        }
    }
}