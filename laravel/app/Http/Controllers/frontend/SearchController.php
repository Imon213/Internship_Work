<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use App\Models\DivisionModel;
use App\Models\DistrictModel;
use App\Models\AreaModel;
use App\Models\ProductModel;
use App\Models\SecondSubcategoryModel;
use URL;

class SearchController extends Controller {

	public function highAddList(Request $request) {
	$url =  URL::previous();
	$get_url = explode('/', $url);
	
	if($get_url[3] === 'cats') {
	
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
   $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $get_url[4])
                ->where('products.products_status', 'Active')
                ->orderBy('products.products_price', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
        return view('frontend.pages.ads.cat_adds', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList'))->with('products_category_id', $get_url[4]);
        } elseif($get_url[3] === 'subcats') {
	
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $get_url[4])
                ->where('products.products_subcategory_id', $get_url[5])
                ->where('products.products_status', 'Active')
                ->orderBy('products.products_price', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[5])->get();
        return view('frontend.pages.ads.subcat', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList', 'secondSubcategory'))->with('products_category_id', $get_url[4])->with('products_subcategory_id', $get_url[5]);
        } elseif($get_url[3] === 'secondsubcats') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_second_subcategory_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        $track_id = SecondSubcategoryModel::where('second_subcategories_track_id', $get_url[4])->first();
	        $subCategoryList = SubCategoryModel::where('subcategories_track_id', $track_id->second_subcategories_subcategories_id)->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $track_id->second_subcategories_subcategories_id)->get();
	        return view('frontend.pages.ads.subcat', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList', 'secondSubcategory'))->with('products_category_id', $track_id->second_subcategories_category_id)->with('products_subcategory_id', $track_id->second_subcategories_category_id)->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'division') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $districtList = DistrictModel::where('districts_division_id', $get_url[4])->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_division_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	               ->orderBy('products.products_price', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        return view('frontend.pages.ads.division', compact('dataList', 'categoryList', 'divisionList', 'districtList'))->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'district') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_division_id', $get_url[4])
	                ->where('products.products_district_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $districtList = DistrictModel::where('districts_division_id', $get_url[4])->get();
	        $areaList = AreaModel::where('areas_district_id', $get_url[5])->get();
	        return view('frontend.pages.ads.district', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList'))->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'area') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_area_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        $track_id = AreaModel::where('areas_track_id', $get_url[4])->first();
	        $districtList = DistrictModel::where('districts_track_id', $track_id->areas_district_id)->get();
	        $areaList = AreaModel::where('areas_district_id', $track_id->areas_district_id)->get();
	        return view('frontend.pages.ads.district', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList'))->with('products_division_id', $track_id->areas_dvision_id);
	    } elseif($get_url[3] === 'catDiv') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_category_id', $get_url[4])
	                ->where('products.products_division_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $districtList = DistrictModel::where('districts_division_id', $get_url[5])->get();
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
	        return view('frontend.pages.ads.catDiv', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'subCategoryList'))->with('products_division_id', $get_url[5])->with('products_category_id', $get_url[4]);
	    } elseif($get_url[3] === 'subDiv') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_subcategory_id', $get_url[4])
	                ->where('products.products_division_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $subcategories_category_id = SubcategoryModel::where('subcategories_track_id', $get_url[4])->first()->subcategories_category_id;
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $subcategories_category_id)->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[4])->get();
	        $districtList = DistrictModel::where('districts_division_id', $get_url[5])->get();
	        return view('frontend.pages.ads.subDiv', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'subCategoryList', 'secondSubcategory', 'subcategories_category_id'))->with('products_subcategory_id', $get_url[4])->with('products_division_id', $get_url[5]);
	    } elseif($get_url[3] === 'subDis') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_subcategory_id', $get_url[4])
	                ->where('products.products_district_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $disId = DistrictModel::where('districts_track_id', $get_url[5])->first()->districts_division_id;
	        $districtList = DistrictModel::where('districts_division_id', $disId)->get();
	        $subId = SubcategoryModel::where('subcategories_track_id', $get_url[4])->first()->subcategories_category_id;
	        $areaList = AreaModel::where('areas_district_id', $get_url[5])->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[4])->get();
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $subId)->get();
	
	        return view('frontend.pages.ads.subDis', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'districtList', 'secondSubcategory', 'subCategoryList'))->with('products_category_id', $subId )->with('products_subcategory_id', $get_url[4])->with('products_district_id', $get_url[5])->with('products_division_id', $disId);
	    } else {
	    	 $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        return view('frontend.pages.ads.allAdd', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'districtList', 'secondSubcategory', 'subCategoryList'));
	    }
        
    }
    
    public function lowAddList(Request $request) {
	$url =  URL::previous();
	$get_url = explode('/', $url);
	
	if($get_url[3] === 'cats') {
	
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
   $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $get_url[4])
                ->where('products.products_status', 'Active')
                ->orderBy('products.products_price', 'ASC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
        return view('frontend.pages.ads.cat_adds', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList'))->with('products_category_id', $get_url[4]);
        } elseif($get_url[3] === 'subcats') {
	
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $get_url[4])
                ->where('products.products_subcategory_id', $get_url[5])
                ->where('products.products_status', 'Active')
                ->orderBy('products.products_price', 'ASC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[5])->get();
        return view('frontend.pages.ads.subcat', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList', 'secondSubcategory'))->with('products_category_id', $get_url[4])->with('products_subcategory_id', $get_url[5]);
        } elseif($get_url[3] === 'secondsubcats') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_second_subcategory_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'ASC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        $track_id = SecondSubcategoryModel::where('second_subcategories_track_id', $get_url[4])->first();
	        $subCategoryList = SubCategoryModel::where('subcategories_track_id', $track_id->second_subcategories_subcategories_id)->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $track_id->second_subcategories_subcategories_id)->get();
	        return view('frontend.pages.ads.subcat', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList', 'secondSubcategory'))->with('products_category_id', $track_id->second_subcategories_category_id)->with('products_subcategory_id', $track_id->second_subcategories_category_id)->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'division') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $districtList = DistrictModel::where('districts_division_id', $get_url[4])->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_division_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	               ->orderBy('products.products_price', 'ASC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        return view('frontend.pages.ads.division', compact('dataList', 'categoryList', 'divisionList', 'districtList'))->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'district') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_division_id', $get_url[4])
	                ->where('products.products_district_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'ASC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $districtList = DistrictModel::where('districts_division_id', $get_url[4])->get();
	        $areaList = AreaModel::where('areas_district_id', $get_url[5])->get();
	        return view('frontend.pages.ads.district', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList'))->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'area') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_area_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'ASC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        $track_id = AreaModel::where('areas_track_id', $get_url[4])->first();
	        $districtList = DistrictModel::where('districts_track_id', $track_id->areas_district_id)->get();
	        $areaList = AreaModel::where('areas_district_id', $track_id->areas_district_id)->get();
	        return view('frontend.pages.ads.district', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList'))->with('products_division_id', $track_id->areas_dvision_id);
	    } elseif($get_url[3] === 'catDiv') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_category_id', $get_url[4])
	                ->where('products.products_division_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'ASC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $districtList = DistrictModel::where('districts_division_id', $get_url[5])->get();
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
	        return view('frontend.pages.ads.catDiv', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'subCategoryList'))->with('products_division_id', $get_url[5])->with('products_category_id', $get_url[4]);
	    } elseif($get_url[3] === 'subDiv') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_subcategory_id', $get_url[4])
	                ->where('products.products_division_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'ASC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $subcategories_category_id = SubcategoryModel::where('subcategories_track_id', $get_url[4])->first()->subcategories_category_id;
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $subcategories_category_id)->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[4])->get();
	        $districtList = DistrictModel::where('districts_division_id', $get_url[5])->get();
	        return view('frontend.pages.ads.subDiv', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'subCategoryList', 'secondSubcategory', 'subcategories_category_id'))->with('products_subcategory_id', $get_url[4])->with('products_division_id', $get_url[5]);
	    } elseif($get_url[3] === 'subDis') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_subcategory_id', $get_url[4])
	                ->where('products.products_district_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'ASC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $disId = DistrictModel::where('districts_track_id', $get_url[5])->first()->districts_division_id;
	        $districtList = DistrictModel::where('districts_division_id', $disId)->get();
	        $subId = SubcategoryModel::where('subcategories_track_id', $get_url[4])->first()->subcategories_category_id;
	        $areaList = AreaModel::where('areas_district_id', $get_url[5])->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[4])->get();
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $subId)->get();
	
	        return view('frontend.pages.ads.subDis', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'districtList', 'secondSubcategory', 'subCategoryList'))->with('products_category_id', $subId )->with('products_subcategory_id', $get_url[4])->with('products_district_id', $get_url[5])->with('products_division_id', $disId);
	    } else {
	    	 $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_status', 'Active')
	                ->orderBy('products.products_price', 'ASC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        return view('frontend.pages.ads.allAdd', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'districtList', 'secondSubcategory', 'subCategoryList'));
	    }        
    }
    
    public function oldAddList(Request $request) {
	$url =  URL::previous();
	$get_url = explode('/', $url);
	
	if($get_url[3] === 'cats') {
	
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
   $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $get_url[4])
                ->where('products.products_status', 'Active')
                ->where('products.products_type', 'Old')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
        return view('frontend.pages.ads.cat_adds', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList'))->with('products_category_id', $get_url[4]);
        } elseif($get_url[3] === 'subcats') {
	
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $get_url[4])
                ->where('products.products_subcategory_id', $get_url[5])
                ->where('products.products_status', 'Active')
                ->where('products.products_type', 'Old')
               		->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[5])->get();
        return view('frontend.pages.ads.subcat', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList', 'secondSubcategory'))->with('products_category_id', $get_url[4])->with('products_subcategory_id', $get_url[5]);
        } elseif($get_url[3] === 'secondsubcats') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_second_subcategory_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'Old')
               		->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        $track_id = SecondSubcategoryModel::where('second_subcategories_track_id', $get_url[4])->first();
	        $subCategoryList = SubCategoryModel::where('subcategories_track_id', $track_id->second_subcategories_subcategories_id)->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $track_id->second_subcategories_subcategories_id)->get();
	        return view('frontend.pages.ads.subcat', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList', 'secondSubcategory'))->with('products_category_id', $track_id->second_subcategories_category_id)->with('products_subcategory_id', $track_id->second_subcategories_category_id)->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'division') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $districtList = DistrictModel::where('districts_division_id', $get_url[4])->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_division_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	               ->where('products.products_type', 'Old')
               		->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        return view('frontend.pages.ads.division', compact('dataList', 'categoryList', 'divisionList', 'districtList'))->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'district') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_division_id', $get_url[4])
	                ->where('products.products_district_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'Old')
                ->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $districtList = DistrictModel::where('districts_division_id', $get_url[4])->get();
	        $areaList = AreaModel::where('areas_district_id', $get_url[5])->get();
	        return view('frontend.pages.ads.district', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList'))->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'area') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_area_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'Old')
                ->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        $track_id = AreaModel::where('areas_track_id', $get_url[4])->first();
	        $districtList = DistrictModel::where('districts_track_id', $track_id->areas_district_id)->get();
	        $areaList = AreaModel::where('areas_district_id', $track_id->areas_district_id)->get();
	        return view('frontend.pages.ads.district', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList'))->with('products_division_id', $track_id->areas_dvision_id);
	    } elseif($get_url[3] === 'catDiv') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_category_id', $get_url[4])
	                ->where('products.products_division_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	               ->where('products.products_type', 'Old')
                ->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $districtList = DistrictModel::where('districts_division_id', $get_url[5])->get();
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
	        return view('frontend.pages.ads.catDiv', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'subCategoryList'))->with('products_division_id', $get_url[5])->with('products_category_id', $get_url[4]);
	    } elseif($get_url[3] === 'subDiv') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_subcategory_id', $get_url[4])
	                ->where('products.products_division_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'Old')
                	->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $subcategories_category_id = SubcategoryModel::where('subcategories_track_id', $get_url[4])->first()->subcategories_category_id;
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $subcategories_category_id)->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[4])->get();
	        $districtList = DistrictModel::where('districts_division_id', $get_url[5])->get();
	        return view('frontend.pages.ads.subDiv', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'subCategoryList', 'secondSubcategory', 'subcategories_category_id'))->with('products_subcategory_id', $get_url[4])->with('products_division_id', $get_url[5]);
	    } elseif($get_url[3] === 'subDis') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_subcategory_id', $get_url[4])
	                ->where('products.products_district_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'Old')
                	->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $disId = DistrictModel::where('districts_track_id', $get_url[5])->first()->districts_division_id;
	        $districtList = DistrictModel::where('districts_division_id', $disId)->get();
	        $subId = SubcategoryModel::where('subcategories_track_id', $get_url[4])->first()->subcategories_category_id;
	        $areaList = AreaModel::where('areas_district_id', $get_url[5])->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[4])->get();
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $subId)->get();
	
	        return view('frontend.pages.ads.subDis', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'districtList', 'secondSubcategory', 'subCategoryList'))->with('products_category_id', $subId )->with('products_subcategory_id', $get_url[4])->with('products_district_id', $get_url[5])->with('products_division_id', $disId);
	    } else {
	    	 $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'Old')
                	->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        return view('frontend.pages.ads.allAdd', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'districtList', 'secondSubcategory', 'subCategoryList'));
	    }
        
    }
    public function newAddList(Request $request) {
	$url =  URL::previous();
	$get_url = explode('/', $url);
	
	if($get_url[3] === 'cats') {
	
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
   $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $get_url[4])
                ->where('products.products_status', 'Active')
                ->where('products.products_type', 'New')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
        return view('frontend.pages.ads.cat_adds', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList'))->with('products_category_id', $get_url[4]);
        } elseif($get_url[3] === 'subcats') {
	
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $get_url[4])
                ->where('products.products_subcategory_id', $get_url[5])
                ->where('products.products_status', 'Active')
                ->where('products.products_type', 'New')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[5])->get();
        return view('frontend.pages.ads.subcat', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList', 'secondSubcategory'))->with('products_category_id', $get_url[4])->with('products_subcategory_id', $get_url[5]);
        } elseif($get_url[3] === 'secondsubcats') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_second_subcategory_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'New')
               		->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        $track_id = SecondSubcategoryModel::where('second_subcategories_track_id', $get_url[4])->first();
	        $subCategoryList = SubCategoryModel::where('subcategories_track_id', $track_id->second_subcategories_subcategories_id)->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $track_id->second_subcategories_subcategories_id)->get();
	        return view('frontend.pages.ads.subcat', compact('dataList', 'categoryList', 'divisionList', 'subCategoryList', 'secondSubcategory'))->with('products_category_id', $track_id->second_subcategories_category_id)->with('products_subcategory_id', $track_id->second_subcategories_category_id)->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'division') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $districtList = DistrictModel::where('districts_division_id', $get_url[4])->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_division_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	               ->where('products.products_type', 'New')
               		->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        return view('frontend.pages.ads.division', compact('dataList', 'categoryList', 'divisionList', 'districtList'))->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'district') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_division_id', $get_url[4])
	                ->where('products.products_district_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'New')
                ->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $districtList = DistrictModel::where('districts_division_id', $get_url[4])->get();
	        $areaList = AreaModel::where('areas_district_id', $get_url[5])->get();
	        return view('frontend.pages.ads.district', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList'))->with('products_division_id', $get_url[4]);
	    } elseif($get_url[3] === 'area') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_area_id', $get_url[4])
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'New')
                ->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        $track_id = AreaModel::where('areas_track_id', $get_url[4])->first();
	        $districtList = DistrictModel::where('districts_track_id', $track_id->areas_district_id)->get();
	        $areaList = AreaModel::where('areas_district_id', $track_id->areas_district_id)->get();
	        return view('frontend.pages.ads.district', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList'))->with('products_division_id', $track_id->areas_dvision_id);
	    } elseif($get_url[3] === 'catDiv') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_category_id', $get_url[4])
	                ->where('products.products_division_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	               ->where('products.products_type', 'New')
                ->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $districtList = DistrictModel::where('districts_division_id', $get_url[5])->get();
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $get_url[4])->get();
	        return view('frontend.pages.ads.catDiv', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'subCategoryList'))->with('products_division_id', $get_url[5])->with('products_category_id', $get_url[4]);
	    } elseif($get_url[3] === 'subDiv') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_subcategory_id', $get_url[4])
	                ->where('products.products_division_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'New')
                	->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $subcategories_category_id = SubcategoryModel::where('subcategories_track_id', $get_url[4])->first()->subcategories_category_id;
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $subcategories_category_id)->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[4])->get();
	        $districtList = DistrictModel::where('districts_division_id', $get_url[5])->get();
	        return view('frontend.pages.ads.subDiv', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'subCategoryList', 'secondSubcategory', 'subcategories_category_id'))->with('products_subcategory_id', $get_url[4])->with('products_division_id', $get_url[5]);
	    } elseif($get_url[3] === 'subDis') {
	
	        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_subcategory_id', $get_url[4])
	                ->where('products.products_district_id', $get_url[5])
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'New')
                	->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	        $disId = DistrictModel::where('districts_track_id', $get_url[5])->first()->districts_division_id;
	        $districtList = DistrictModel::where('districts_division_id', $disId)->get();
	        $subId = SubcategoryModel::where('subcategories_track_id', $get_url[4])->first()->subcategories_category_id;
	        $areaList = AreaModel::where('areas_district_id', $get_url[5])->get();
	        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $get_url[4])->get();
	        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $subId)->get();
	
	        return view('frontend.pages.ads.subDis', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'districtList', 'secondSubcategory', 'subCategoryList'))->with('products_category_id', $subId )->with('products_subcategory_id', $get_url[4])->with('products_district_id', $get_url[5])->with('products_division_id', $disId);
	    } else {
	    	 $categoryList = CategoryModel::where('categories_status', 'Active')->get();
	        $divisionList = DivisionModel::where('division_status', 'Active')->get();
	        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
	                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
	                ->where('products.products_status', 'Active')
	                ->where('products.products_type', 'New')
                	->orderBy('products.created_at', 'DESC')
	                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
	                ->paginate(15);
	
	        return view('frontend.pages.ads.allAdd', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'districtList', 'secondSubcategory', 'subCategoryList'));
	    }
        
    } 
    
    
    public function search(Request $request) {
        $searchText = $request->input('searchText');
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->leftJoin('categories', 'products.products_category_id', 'categories.categories_track_id')
                ->leftJoin('subcategories', 'products.products_subcategory_id', 'subcategories.subcategories_track_id')
                ->where('products.products_status', 'Active')
                ->Where('districts.districts_name', 'LIKE', '%' . $searchText . '%')
                ->orWhere('areas.areas_name', 'LIKE', '%' . $searchText . '%')
                 ->orWhere('categories.categories_name', 'LIKE', '%' . $searchText . '%')
                 ->orWhere('subcategories.subcategories_name', 'LIKE', '%' . $searchText . '%')
                ->orWhere('products.products_name', 'LIKE', '%' . $searchText . '%')
                ->orWhere('products.products_mobile_no', 'LIKE', '%' . $searchText . '%')
                ->orWhere('products.products_price', 'LIKE', '%' . $searchText . '%')
                ->orWhere('products.products_view', 'LIKE', '%' . $searchText . '%')
        	->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
	
	return view('frontend.pages.ads.allAdd', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'districtList', 'secondSubcategory', 'subCategoryList'));
    }
}