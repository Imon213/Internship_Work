<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use App\Models\DivisionModel;
use App\Models\ProductModel;
use App\Models\User;
use App\Models\CommentModel;
use App\Models\ProductImageModel;
use Illuminate\Support\Facades\Auth;
use App\Models\RandomNumberModel;
use Illuminate\Support\Facades\Input;
use App\Models\PropertyModel;

class AdvertiseController extends Controller {

    public function details($id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('users', 'products.products_users_id', 'users.users_track_id')
                ->where('products_track_id', $id)
                ->select('products.*', 'users.users_name', 'users.users_phone', 'users.users_image')
                ->first();
                
                $featureList  ='';
                
                if(!empty($dataList->products_property_id)) {
               $property= explode(',', $dataList->products_property_id);
               foreach($property as $f) {
              $featureList .= PropertyModel::where('properties_id', $f)->first()->properties_name . ',';
               }
               
             $featureList = $featureList ;
                
                 }
        $commentList = CommentModel::leftJoin('users', 'comments.comments_users_id', 'users.users_track_id')
                ->where('comments_products_id', $id)
                ->where('comments_status', 'Active')
                ->select('comments.*', 'users.users_name', 'users.users_image')
                ->orderBy('created_at', 'DESC')
                ->limit(10)
                ->get();

        $imageList = ProductImageModel::where('product_image_track_id', $id)->get();

        $relatedAddList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->leftJoin('users', 'products.products_users_id', 'users.users_track_id')
                ->where('products_subcategory_id', $dataList->products_subcategory_id)
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->select('products.*', 'users.users_name', 'users.users_phone', 'districts.districts_name', 'areas.areas_name')
                ->get();

        $products_view = $dataList->products_view;
        $products_view = $products_view + 1;
        $dataList->products_view = $products_view;
        $dataList->save();

        return view('frontend.pages.ads.details', compact('dataList', 'imageList', 'featureList', 'relatedAddList', 'products_view', 'categoryList', 'divisionList', 'commentList'))->with('products_track_id', $id);
    }

    public function commentStore(Request $request) {
        $comments_details =$request->comments_details;
        $products_track_id = $request->products_track_id;
        if (!empty($comments_details)) {
            if (Auth::check()) {
                $randomNumber = new RandomNumberModel;
                $trackId = $randomNumber->randomNumber(5, 10) . date('YmdHis');

                $dataList = new CommentModel;
                $dataList->comments_users_id = Auth::user()->users_track_id;
                $dataList->comments_products_id = $products_track_id;
                $dataList->comments_details = $comments_details;
                $dataList->comments_track_id = $trackId;
                $dataList->comments_status = 'Active';
                if ($dataList->save()) {
                    return redirect()->back()->with('success', 'Your comment has been successfully posted.');
                }
            } else {
                return redirect()->back()->with('error', 'Please sign in for comment');
            }
        } else {
            return redirect()->back()->with('error', 'Comment field cannot be empty');
        }
    }

}
