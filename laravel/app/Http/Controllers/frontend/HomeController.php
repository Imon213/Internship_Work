<?php

namespace App\Http\Controllers\frontend;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubcategoryModel;
use App\Models\DivisionModel;
use App\Models\ProductModel;
use App\Models\SecondSubcategoryModel;

class HomeController extends Controller {

    public function home() {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        return view('frontend.pages.index', compact('categoryList', 'divisionList'));
    }

    public function headerTwo() {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        return view('frontend.layouts.header2', compact('categoryList', 'divisionList'));
    }

    public function addList() {
        return view('frontend.pages.allAdd');
    }

    public function catList($id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $id)->get();
        return view('frontend.pages.ads.cat_adds', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList'))->with('products_category_id', $id);
    }

    public function subcatList($catId, $id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $catId)
                ->where('products.products_subcategory_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $catId)->get();
        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $id)->get();
        return view('frontend.pages.ads.subcat', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList', 'secondSubcategory'))->with('products_category_id', $catId)->with('products_subcategory_id', $id);
    }
    
    public function secondsubcats($id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_second_subcategory_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);

        $track_id = SecondSubcategoryModel::where('second_subcategories_track_id', $id)->first();
        $subCategoryList = SubCategoryModel::where('subcategories_track_id', $track_id->second_subcategories_subcategories_id)->get();
        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $track_id->second_subcategories_subcategories_id)->get();
        return view('frontend.pages.ads.secondSubCat', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList', 'secondSubcategory'))->with('products_category_id', $track_id->second_subcategories_category_id)->with('products_subcategory_id', $track_id->second_subcategories_subcategories_id)->with('products_division_id', $id);
    }

}
