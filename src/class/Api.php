<?php
class Api {
    function __construct(){
    }

    public function checkout ($api_key){
        $result = false;
        $api =  ApiClass::select('key')->where('key', $api_key)->get();

        if ($api_key == $api[0]->key){
           $result = true;
       }
       return $result;
    }

}