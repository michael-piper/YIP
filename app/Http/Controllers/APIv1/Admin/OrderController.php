<?php

namespace App\Http\Controllers\APIv1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductSubCategory;
use App\ProductCategory;
use App\PaymentStatus;
use App\OrderStatus;
use App\Product;
use App\Order;
use App\User;
class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $orders= Order::all();
        if(count($orders)>0){
            foreach($orders as $key=>$order){
                $orders[$key]->order_status=OrderStatus::where('id',$order->order_status)->first();
                $orders[$key]->payment_status=PaymentStatus::where('id',$order->payment_status)->first();
                $orders[$key]->product=Product::where('id',$order->product_id)->first();
                $orders[$key]->product->category=ProductCategory::where('id',$orders[$key]->product->category_id)->first();
                $orders[$key]->product->sub_category=ProductSubCategory::where('id',$orders[$key]->product->sub_category_id)->first();
            }
        }
        return response()->json([
            'error' => false,
            'data'  =>$orders,
        ], 200);
    }
    public function store(Request $request)
    {

        return response()->json([
            'error' => true,
            'message'  => '',
        ], 404);
    }

    public function show($id)
    {
        $order=Order::where(['id'=>$id])->first();
        if(is_null($order)){
            return response()->json([
                'error' => true,
                'message'  => "Order with id not found",
            ], 404);
        }
        return response()->json([
            'error' => false,
            'data'  =>$order,
        ], 200);
    }
    public function update(Request $request, $id)
    {
        if($request->method()=='PATCH'){
            $order = Order::where(['id'=>$id])->first();
            $touch=false;
            if(is_null($order)){
                return response()->json([
                    'error' => true,
                    'message'  => "Order with id # $id not found",
                ], 404);
            }
            $whitelist=['order-status'];
            foreach($request->input() as $name=>$input){
                if(in_array($name,$whitelist)){
                    $order->{$name}=$input;
                    $touch=true;
                }
            }
            if($touch == false){
                return response()->json([
                    'error' => true,
                    'message'  => "Nothing to update in Order data",
                ], 200);
            }
            $order->save();
            return response()->json([
                'error' => false,
                'message'  => 'Order Updated',
            ], 404);
        }
    }
    public function destroy($id)
    {
        $order = Order::where(['id'=>$id])->first();
        if(is_null($order)){
            return response()->json([
                'error' => true,
                'message'  => "Order with id # $id not found",
            ], 404);
        }
        $order->delete();
        return response()->json([
            'error' => false,
            'message'  => "Product successfully deleted id # $id",
        ], 200);
    }
}
