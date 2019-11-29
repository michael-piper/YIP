<?php

namespace App\Http\Controllers\APIv1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductCategory;
use App\User;
class CategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $categories= ProductCategory::all();
        return response()->json([
            'error' => false,
            'data'  =>$categories,
        ], 200);
    }
    public function store(Request $request)
    {
        $values=$request->only('name','description');
        if(is_null($values['name'])){
            return response()->json([
                'error' => true,
                'message'  => "Category name required",
            ], 200);
        }
        $category= new ProductCategory;
        $category->name=$request->name;
        $category->description=$request->description;
        $category->save();
        return response()->json([
            'error' => false,
            'message'  => "Category successfully created",
        ], 200);
    }
    public function destroy($id)
    {
        $category = ProductCategory::where(['id'=>$id])->first();
        if(is_null($category)){
            return response()->json([
                'error' => true,
                'message'  => "Category with id # $id not found",
            ], 404);
        }
        $category->delete();
        return response()->json([
            'error' => false,
            'message'  => "Category successfully deleted id # $id",
        ], 200);
    }
}
