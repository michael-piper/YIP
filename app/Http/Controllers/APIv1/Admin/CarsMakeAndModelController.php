<?php

namespace App\Http\Controllers\APIv1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductAutoFill;
class CarsMakeAndModelController extends Controller
{
    //
    function index(){
        $autofills=ProductAutoFill::where(['name'=>'car_makes'])->first();
        $data=json_decode($autofills->value,true);
        if(!is_array($data))$data=[];
        return response()->json([
            'error' => false,
            'data'  =>$data,
        ], 200);
    }
    public function store(Request $request)
    {
        $values=$request->only('make','model');
        $autofills=ProductAutoFill::where(['name'=>'car_makes'])->first();
        if(is_null($values['make']) || is_null($values['model']))
        return response()->json(['error'=>true,'message'=>'Make and Model can\'t be empty']);
        if(is_null($autofills)){
            $autofills=new ProductAutoFill;
            $autofills->name='car_makes';
            $autofills->value='[]';
        }
        $data=json_decode($autofills->value,true);
        if(!is_array($data))$data=[];
        if(is_array($data)){
            $data[]=$values;
        }
        $autofills->value=json_encode($data,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        $autofills->save();
        return response()->json(['error'=>false,'message'=>'Make and Model created']);
    }
    public function show ($id)
    {
        $autofills=ProductAutoFill::where(['name'=>'car_makes'])->first();
        if(is_null($autofills)){
            $autofills=new ProductAutoFill;
            $autofills->name='car_makes';
            $autofills->value='[]';
        }
        $data=json_decode($autofills->value,true);
        if(!is_array($data))$data=[];
        if(is_array($data) && array_key_exists($id,$data)){
            return response()->json(['error'=>false,'data'=>$data[$id]]);
        }else{
            return response()->json(['error'=>true,'message'=>'Make and Model doesn\'t exists']);
        }
        return response()->json(['error'=>false,'message'=>'Make and Model updated']);
    }
    public function update(Request $request, $id)
    {
        $values=$request->only('make','model');
        $autofills=ProductAutoFill::where(['name'=>'car_makes'])->first();
        if(is_null($values['make']) || is_null($values['model']))
        return response()->json(['error'=>true,'message'=>'Make and Model can\'t be empty']);
        if(is_null($autofills)){
            $autofills=new ProductAutoFill;
            $autofills->name='car_makes';
            $autofills->value='[]';
        }
        $data=json_decode($autofills->value,true);
        if(!is_array($data))$data=[];
        if(is_array($data) && array_key_exists($id,$data)){
            $data[$id]=$values;
        }else{
            return response()->json(['error'=>true,'message'=>'Make and Model doesn\'t exists']);
        }
        $autofills->value=json_encode($data,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        $autofills->save();
        return response()->json(['error'=>false,'message'=>'Make and Model updated']);
    }
    public function destroy($id)
    {
        $autofills=ProductAutoFill::where(['name'=>'car_makes'])->first();
        if(is_null($autofills)){
            $autofills=new ProductAutoFill;
            $autofills->name='car_makes';
            $autofills->value='[]';
        }
        $data=json_decode($autofills->value,true);
        if(!is_array($data))$data=[];
        if(is_array($data))
        unset($data[$id]);
        $newdata=[];
        foreach ($data as $value) {
            # code...
            $newdata[]=$value;
        }
        $autofills->value=json_encode($newdata,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        $autofills->save();
        return response()->json(['error'=>false,'message'=>'make and model deleted']);
    }
}
