<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\User;
use App\UserDetail;
use App\ProductAvailable;
use App\Product;
class ActionController extends Controller
{
    static function tryRegisterCustomer($request){
        $newuser= new User();
        $newuser->display_name=$request->name;
        $newuser->email=$request->email;
        $newuser->phone=$request->phone;
        $newuser->type=1;
        $newuser->display_type="Customer";
        $newuser->api_token=time().Str::random(22);
        $newuser->password=bcrypt($request->password);
        if($newuser->save() && $newuser->refresh()){
            $addons=(object)["address"=>$request->address];
            $contact=(object)[];
            $newuser_detail=new UserDetail();
            $newuser_detail->user_id=$newuser->id;
            $newuser_detail->addons=json_encode($addons);
            $newuser_detail->contact=json_encode($contact);
            $newuser_detail->save();
            return true;
        }
        return false;
    }
    static function tryRegisterVendor($request){
        $newuser= new User();
        $newuser->display_name=$request->name;
        $newuser->email=$request->email;
        $newuser->phone=$request->phone;
        $newuser->type=2;
        $newuser->display_type="Vendor";
        $newuser->api_token=time().Str::random(22);
        $newuser->password=bcrypt($request->password);
        if($newuser->save() && $newuser->refresh()){
            $addons=(object)["address"=>$request->address,"contact_person"=>$request->contact_name,'state'=>$request->state,'id_card_type'=>$request->id_card_type,'id_card_number'=>$request->id_card_number];
            $contact=(object)[];
            $newuser_detail=new UserDetail();
            $newuser_detail->user_id=$newuser->id;
            $newuser_detail->addons=json_encode($addons);
            $newuser_detail->contact=json_encode($contact);
            $newuser_detail->save();
            return true;
        }
        return false;
    }
    static function tryAddProduct($request){
        $user=User::from_api_token();
        if(!$user) return false;
        $product= new Product();
        $product->name=$request->name;
        $product->price=$request->price;
        $product->available=0;
        $product->category_id=$request->category;
        $product->sub_category_id=$request->subcategory;
        $product->user_id=$user->id;
        $product->display_image=null;
        $product->condition=$request->condition;
        $product->description=$request->description;
        $year=$request->input("year");
        if($request->input("discount")){
            $product->addons(['discount'=>$request->input("discount")],true);
        }else{
            $product->addons(['discount'=>0],true);
        }
        if($request->hasFile("image")){
            $image = $request->file("image");
            $product->defaultImage($image);
        }
        if(is_array($year)){
            $product->year=implode(';',$year);
        }else{
            $product->year=$year;
        }
        $product->make=$request->make;
        $product->model=$request->model;
        if($product->save() && $product->refresh()){
            return $product;
        }
        return false;
    }
    static function tryEditProduct($request){
        $user=User::from_api_token();
        if(is_null($user)) return false;
        $product = Product::where('id',$request->input('product_id'))->first();
        if(is_null($product)) return false;
        $product->name=$request->name;
        $product->price=$request->price;
        $product->category_id=$request->category;
        $product->sub_category_id=$request->subcategory;
        $product->user_id=$user->id;
        $product->condition=$request->condition;
        $product->description=$request->description;
        $year=$request->input("year");
        if($request->input("discount")){
            $product->addons(['discount'=>$request->input("discount")]);
        }else{
            $product->addons(['discount'=>0]);
        }
        if($request->hasFile("image")){
            $image = $request->file("image");
            $product->defaultImage($image);
        }
        if(is_array($year)){
            $product->year=implode(';',$year);
        }else{
            $product->year=$year;
        }
        $product->make=$request->make;
        $product->model=$request->model;
        if($product->save() && $product->refresh()){
            return $product;
        }
        return false;
    }
    static function tryAddProductQuantity($product_id,$quantity){
        $quan=new ProductAvailable();
        $quan->product_id=$product_id;
        $quan->quantity=$quantity;
        if($quan->save()){
            $product_availables=ProductAvailable::where('product_id',$product_id)->get();
            $available=0;
            if(!is_null($product_availables)){
                foreach($product_availables as $avail){
                    $available=$available+ $avail->quantity;
                }
            }
            $product=Product::where('id',$product_id)->first();
            $product->available=$available;
            $product->save();
            return true;
        }
        return false;
    }
}
