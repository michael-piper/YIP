<?php

namespace App\Http\Controllers\APIv1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductSubCategory;
use App\ProductCategory;
use App\User;
class SubCategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $sub_categories= ProductSubCategory::all();
        if(count($sub_categories)>0){
            foreach($sub_categories as $key=>$sub_category){
                $sub_categories[$key]->category=ProductCategory::where('id',$sub_category->category_id)->first();
            }
        }
        return response()->json([
            'error' => false,
            'data'  =>$sub_categories,
        ], 200);
    }
    public function store(Request $request)
    {
        $values=$request->only('name','category_id','description');
        if(is_null($values['name'])){
            return response()->json([
                'error' => true,
                'message'  => "Sub Category name required",
            ], 200);
        }
        $category=ProductCategory::where('id',$values['category_id'])->first();
        if(is_null($category)){
            return response()->json([
                'error' => true,
                'message'  => "Invalid Category id",
            ], 200);
        }
        $sub_category= new ProductSubCategory;
        $sub_category->name=$request->name;
        $sub_category->category_id=$request->category_id;
        $sub_category->description=$request->description;
        $sub_category->save();
        return response()->json([
            'error' => false,
            'message'  => "Sub Category successfully created",
        ], 200);
    }
    public function destroy($id)
    {
        $sub_category = ProductSubCategory::where(['id'=>$id])->first();
        if(is_null($sub_category)){
            return response()->json([
                'error' => true,
                'message'  => "Sub Category with id # $id not found",
            ], 404);
        }
        $sub_category->delete();
        return response()->json([
            'error' => false,
            'message'  => "Sub Category successfully deleted id # $id",
        ], 200);
    }
}
