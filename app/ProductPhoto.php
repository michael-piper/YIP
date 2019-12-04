<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    //
    function addImage($image){
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
            if(isset($this->filename) && is_file($this->filename)){
                unlink($this->filename);
            }
            $this->filename = $dir_url. $image_name;
            return true;
        }else{
            return false;
        }
    }
    function removeImage(){
        if(isset($this->filename) && $this->filename != '/images/products/placeholder.png' && is_file($this->filename)){
            unlink($this->filename);
        }
        $this->filename = '/images/products/placeholder.png';
        return true;
    }
}
