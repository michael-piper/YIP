<?php

namespace App\Http\Controllers\APIv1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\PaymentStatus;
class PaymentStatusController extends Controller
{
    //
    public function index()
    {

        $payment_status= PaymentStatus::all();

        return response()->json([
            'error' => false,
            'data'  =>$payment_status,
        ], 200);
    }
    public function store(Request $request){
        $values=$request->only('name','description');
        if(is_null($values['name'])){
            return response()->json([
                'error' => true,
                'message'  => "Payment Status name required",
            ], 200);
        }
        $payment_status= new PaymentStatus;
        $payment_status->name=$request->name;
        $payment_status->description=$request->description;
        $payment_status->save();
        return response()->json([
            'error' => false,
            'message'  => "Payment Status successfully created",
        ], 200);
    }
    public function show($id){
        $payment_status = PaymentStatus::where(['id'=>$id])->first();
        if(is_null($payment_status)){
            return response()->json([
                'error' => true,
                'message'  => "Payment Status with id # $id not found",
            ], 404);
        }
        return response()->json([
            'error' => false,
            'data'  => $payment_status,
        ], 200);
    }
    public function update(Request $request, $id){
        $values=$request->only('name','description');
        if(is_null($values['name'])){
            return response()->json([
                'error' => true,
                'message'  => "Payment Status name required",
            ], 200);
        }
        $payment_status= PaymentStatus::where('id',$id)->first();
        if(is_null($payment_status)){
            return response()->json([
                'error' => true,
                'message'  => "Payment Status with id # $id not found",
            ], 404);
        }
        $payment_status->name=$request->name;
        $payment_status->description=$request->description;
        $payment_status->save();
        return response()->json([
            'error' => false,
            'message'  => "Payment Status successfully updated",
        ], 200);
    }
    public function destroy($id){
        $payment_status = PaymentStatus::where(['id'=>$id])->first();
        if(is_null($payment_status)){
            return response()->json([
                'error' => true,
                'message'  => "Payment Status with id # $id not found",
            ], 404);
        }
        $payment_status->delete();
        return response()->json([
            'error' => false,
            'message'  => "Payment Status successfully deleted id # $id",
        ], 200);
    }
}
