<?php

namespace App\Http\Controllers\APIv1\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Product;
class ProductController extends Controller
{
    //
    public function index()
    {
        $user=User::from_api_token();
        return response()->json([
            'error' => false,
            'data'  => Product::where(['user_id'=>$user->id])->get(),
        ], 200);
    }
    public function destroy($id)
    {
        $user=User::from_api_token();
        $product = Product::where(['user_id'=>$user->id,'id'=>$id])->first();
        if(is_null($product)){
            return response()->json([
                'error' => true,
                'message'  => "Product with id # $id not found",
            ], 404);
        }

        $product->delete();

        return response()->json([
            'error' => false,
            'message'  => "Product successfully deleted id # $id",
        ], 200);
    }
}
