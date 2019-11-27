<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function contact($data=[],$force=false){
        if($force)$contact=[];
        else if(isset($this->contact)){
            $contact=json_decode($this->contact,true);
        }else{
            $contact=[];
        }

        if(is_array($data)){
            foreach($data as $key=>$val){
                $contact[$key]=$val;
            }
        }
        $this->contact=json_encode($contact,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        return json_decode($this->contact);
    }
}
