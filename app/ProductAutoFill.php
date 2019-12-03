<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAutoFill extends Model
{
    //
    static function findme($name="car_makes",$norepeat='make'){
        $autofills=ProductAutoFill::where(['name'=>$name])->first();
        if(!is_null($autofills)){
            $data=json_decode($autofills->value,true);
            $data_res=[];
            $data_norepeat=[];
            foreach($data as $result){
                    if($norepeat){
                        if(array_key_exists($norepeat,$result)){
                            // check if no repeat already declared
                            if(!array_key_exists($result[$norepeat],$data_norepeat)){
                                $data_res[]=$result;
                            }
                            $data_norepeat[$result[$norepeat]]=null;
                        }
                    }else{
                        $data_res[]=$result;
                    }

            }
            return $data_res;
        }else{
            return [];
        }

    }
}
