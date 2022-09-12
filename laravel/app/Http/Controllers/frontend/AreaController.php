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

class AreaController extends Controller {

    public function divList($id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $districtList = DistrictModel::where('districts_division_id', $id)->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_division_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        return view('frontend.pages.ads.division', compact('dataList', 'categoryList', 'divisionList', 'districtList'))->with('products_division_id', $id);
    }

    public function subDivList($subId, $id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_subcategory_id', $subId)
                ->where('products.products_division_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $subcategories_category_id = SubcategoryModel::where('subcategories_track_id', $subId)->first()->subcategories_category_id;
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $subcategories_category_id)->get();
        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $subId)->get();
        $districtList = DistrictModel::where('districts_division_id', $id)->get();
        return view('frontend.pages.ads.subDiv', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'subCategoryList', 'secondSubcategory', 'subcategories_category_id'))->with('products_subcategory_id', $subId)->with('products_division_id', $id);
    }

    public function disList($divId, $id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_division_id', $divId)
                ->where('products.products_district_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $districtList = DistrictModel::where('districts_division_id', $divId)->get();
        $areaList = AreaModel::where('areas_district_id', $id)->get();
        return view('frontend.pages.ads.district', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList'))->with('products_division_id', $divId);
    }

    public function areaList($id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_area_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);

        $track_id = AreaModel::where('areas_track_id', $id)->first();
        $districtList = DistrictModel::where('districts_track_id', $track_id->areas_district_id)->get();
        $areaList = AreaModel::where('areas_district_id', $track_id->areas_district_id)->get();
        return view('frontend.pages.ads.area', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList'))->with('products_division_id', $track_id->areas_dvision_id)->with('products_area_id', $id);
    }

    public function catDivList($catId, $id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $catId)
                ->where('products.products_division_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $districtList = DistrictModel::where('districts_division_id', $id)->get();
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $catId)->get();
        return view('frontend.pages.ads.catDiv', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'subCategoryList'))->with('products_division_id', $id)->with('products_category_id', $catId);
    }

    public function subDisList($catId, $id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $catId)
                ->where('products.products_district_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
       $disId = DistrictModel::where('districts_track_id', $id)->first()->districts_division_id;
        $districtList = DistrictModel::where('districts_division_id', $disId)->get();
        $areaList = AreaModel::where('areas_district_id', $id)->get();
        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_category_id', $catId)->get();
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $catId)->get();

        return view('frontend.pages.ads.subDis', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'districtList', 'secondSubcategory', 'subCategoryList'))->with('products_category_id', $catId)->with('products_district_id', $id)->with('products_division_id', $disId);
    }
    
    public function areaCatList($catId, $id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $catId)
                ->where('products.products_area_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
       $disId = AreaModel::where('areas_track_id', $id)->first()->areas_division_id;
        $districtList = DistrictModel::where('districts_division_id', $disId)->get();
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $catId)->get();
        $areaList = AreaModel::where('areas_district_id', $disId)->get();

        return view('frontend.pages.ads.areaCat', compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList', 'subCategoryList'))->with('products_category_id', $catId)->with('products_area_id', $id);
    }
    
    public function catDisList($catId, $id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
        ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_category_id', $catId)
                ->where('products.products_district_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
                
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $catId)->get();
        $areaList = AreaModel::where('areas_district_id', $id)->get();

        return view('frontend.pages.ads.catDis', compact('dataList', 'categoryList', 'divisionList', 'areaList', 'subCategoryList'))->with('products_category_id', $catId)->with('products_district_id', $id);
    }
    
    public function areaSubCatList($subId, $id) {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_subcategory_id', $subId)
                ->where('products.products_area_id', $id)
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);
        $disId = AreaModel::where('areas_track_id', $id)->first()->areas_district_id;
        $districtList = DistrictModel::where('districts_division_id', $disId)->get();
        $catId =  SubcategoryModel::where('subcategories_track_id', $subId)->first()->subcategories_category_id;
        $subCategoryList = SubcategoryModel::where('subcategories_category_id', $catId)->get();
        $areaList = AreaModel::where('areas_district_id', $disId)->get();
        $secondSubcategory = SecondSubcategoryModel::where('second_subcategories_subcategories_id', $subId)->get();

        return view('frontend.pages.ads.areaSubCat',compact('dataList', 'categoryList', 'divisionList', 'districtList', 'areaList', 'secondSubcategory', 'subCategoryList'))->with('products_category_id', $catId )->with('products_subcategory_id', $subId)->with('products_area_id', $id);
    }
    

    public function allAddList() {
        $categoryList = CategoryModel::where('categories_status', 'Active')->get();
        $divisionList = DivisionModel::where('division_status', 'Active')->get();
        $areaList=AreaModel::where('areas_status', 'Active')->get();
        $districtList=DistrictModel::where('districts_status', 'Active')->get();
        $secondSubcategory =SecondSubcategoryModel::where('second_subcategories_status', 'Active')->get();
        $subCategoryList=SubcategoryModel::where(`subcategories_status`,)->get();
        $dataList = ProductModel::leftJoin('districts', 'products.products_district_id', 'districts.districts_track_id')
                ->leftJoin('areas', 'products.products_area_id', 'areas.areas_track_id')
                ->where('products.products_status', 'Active')
                ->orderBy('products.created_at', 'DESC')
                ->select('products.*', 'districts.districts_name', 'areas.areas_name')
                ->paginate(15);

        return view('frontend.pages.ads.allAdd')->with('dataList',$dataList)->with('categoryList',$categoryList)->with ('divisionList',$divisionList)->with('areaList',$areaList)->with('districtList',$districtList)->with('secondSubcategory',$secondSubcategory)->with('subCategoryList',$subCategoryList);
    }

}
