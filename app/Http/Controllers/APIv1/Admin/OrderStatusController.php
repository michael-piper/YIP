<?php

namespace App\Http\Controllers\APIv1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\OrderStatus;
class OrderStatusController extends Controller
{
    //
    public function index()
    {

        $order_status= OrderStatus::all();

        return response()->json([
            'error' => false,
            'data'  =>$order_status,
        ], 200);
    }
    public function store(Request $request){
        $values=$request->only('name','description');
        if(is_null($values['name'])){
            return response()->json([
                'error' => true,
                'message'  => "Order Status name required",
            ], 200);
        }
        $order_status= new OrderStatus;
        $order_status->name=$request->name;
        $order_status->description=$request->description;
        $order_status->save();
        return response()->json([
            'error' => false,
            'message'  => "Order Status successfully created",
        ], 200);
    }
    public function show($id){
        $order_status = OrderStatus::where(['id'=>$id])->first();
        if(is_null($order_status)){
            return response()->json([
                'error' => true,
                'message'  => "Order Status with id # $id not found",
            ], 404);
        }
        return response()->json([
            'error' => false,
            'data'  => $order_status,
        ], 200);
    }
    public function update(Request $request, $id){
        $values=$request->only('name','description');
        if(is_null($values['name'])){
            return response()->json([
                'error' => true,
                'message'  => "Order Status name required",
            ], 200);
        }
        $order_status= OrderStatus::where('id',$id)->first();
        if(is_null($order_status)){
            return response()->json([
                'error' => true,
                'message'  => "Order Status with id # $id not found",
            ], 404);
        }
        $order_status->name=$request->name;
        $order_status->description=$request->description;
        $order_status->save();
        return response()->json([
            'error' => false,
            'message'  => "Order Status successfully updated",
        ], 200);
    }
    public function destroy($id){
        $order_status = OrderStatus::where(['id'=>$id])->first();
        if(is_null($order_status)){
            return response()->json([
                'error' => true,
                'message'  => "Order Status with id # $id not found",
            ], 404);
        }
        $order_status->delete();
        return response()->json([
            'error' => false,
            'message'  => "Order Status successfully deleted id # $id",
        ], 200);
    }
}
