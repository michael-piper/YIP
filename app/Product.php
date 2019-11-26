<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function addons($data=[],$force=false){
        if($force)$addons=[];
        else if(isset($this->addons)){
            $addons=json_decode($this->addons,true);
        }
        else{
            $addons=[];
        }

        if(is_array($data)){
            foreach($data as $key=>$val){
                $addons[$key]=$val;
            }
        }
        $this->addons=json_encode($addons,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        return json_decode($this->addons);
    }
    static function addImage($image){

    }
    static function currency($name=null){
        $currency=[];
        $currency['NGN']='₦';
        $currency['GBP']='£';
        $currency['USD']='$';
        $currency['EUR']='€';
        if(isset($currency[$name]))
        return $currency[$name];


        return $currency['NGN'];

    }
    static function rating($product_id=null){
        $i=0;
        $rate=mt_rand(0,5);
        $result='<span>';
        while($i<$rate){
            $result.='<i class="fa fa-star fill"></i>';
            $i++;
        }
        while($i<5){
            $result.='<i class="fa fa-star empty"></i>';
            $i++;
        }
       $result.='</span>';
       return $result;
    }
    static function frequentBuy($length=8){
        return Product::where('active',1)->orderBy('sold','DESC')
        ->skip(0)
        ->take($length)->get();
    }
    static function available($product_id){
        if(isset($product_id)){
            $product=Product::where(['id'=>$product_id,'active'=>1])->first();
            if(!is_null($product)){
                if($product->available>$product->sold){
                    return $product->available - $product->sold;
                }else{
                    return 0;
                }
            }
            return 0;
        }
        return 0;
    }
    static function isAvailable($product_id=null,$quantity=1){
        if(isset($product_id)){
            $available=Product::available($product_id);
            if($available >= $quantity){
                return true;
            }
            return false;
        }
        return false;
    }
    public function defaultImage($image){
        $dir='images/products/';
        $dir_url='/images/products/';
        $ext=$image->getClientOriginalExtension();
        $whitelist=['png','jpeg','jpg','gif'];
        if(!in_array(strtolower($ext),$whitelist))
        return false;
        $image_name=time().mt_rand(000,999).md5(time()).'.'.$ext;
        if(!is_dir($dir))
        mkdir($dir,0777,true);
        if($image->move($dir, $image_name)){
            if(isset($this->display_image) && is_file($this->display_image)){
                unlink($this->display_image);
            }
            $this->display_image = url('/').$dir_url. $image_name;
            return true;
        }else{
            return false;
        }

    }
}
