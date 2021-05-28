<?php


namespace App\Http\Traits;


class GeneralTraits
{
    public function response($key='',$value,$msg=''){
        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>$msg
            ],
            $key=>$value]);
    }



}
