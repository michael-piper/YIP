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
            ], 404);
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
    public function show($id)
    {
        $category= ProductCategory::where('id',$id)->first();
        if(is_null($category)){
            return response()->json([
                'error' => true,
                'message'  => "Category with id not found",
            ], 404);
        }
        return response()->json([
            'error' => false,
            'data'  => $category,
        ], 200);
    }
    public function update(Request $request, $id){
        if($request->method()=='PATCH'){
            $category= ProductCategory::where('id',$id)->first();
            if(is_null($category)){
                return response()->json([
                    'error' => true,
                    'message'  => "Category with id not found",
                ], 200);
            }
            $patch=false;
            $msg='';
            $whitelist=['active'];
            foreach($request->input() as $key=>$data){
                if(in_array($key,$whitelist)){
                    $category->{$key}=$data;
                    $patch=true;
                    $msg.=$key.', ';
                }
            }

            if($patch == false){
                return response()->json([
                    'error' => true,
                    'message'  => "Nothing to update",
                ], 200);
            }

            $category->save();
            return response()->json([
                'error' => false,
                'message'  => "Category {$msg} successfully updated",
            ], 200);
        }
        $values=$request->only('name','description');
        if(is_null($values['name'])){
            return response()->json([
                'error' => true,
                'message'  => "Category name required",
            ], 200);
        }
        $category= ProductCategory::where('id',$id)->first();
        if(is_null($category)){
            return response()->json([
                'error' => true,
                'message'  => "Category with id not found",
            ], 200);
        }
        $category->name=$request->name;
        $category->description=$request->description;
        $category->save();
        return response()->json([
            'error' => false,
            'message'  => "Category successfully updated",
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
