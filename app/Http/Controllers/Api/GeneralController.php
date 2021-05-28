<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Category;
use App\Models\Constants;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function homeContent(){

        $category = Category::select('id','s_image',
            's_name_'.app()->getLocale() .' as s_name',
            's_description_'.app()->getLocale() .' as s_description'
        )->get();
        $ads = Ads::all();
        $offers =Product::select('id',
            's_name_'.app()->getLocale() .' as s_name',
            's_description_'.app()->getLocale() .' as s_description',
            's_image','b_is_offer','f_old_price','f_new_price','i_category_id')
            ->where('b_is_offer','=',true)->get();

         return response()->json(
             [

                 'status'=>[
                     'success'=>true,
                     'code'=> 1,
                     'message'=>'done'

                     ],

                   'category'=>$category,
                   'offers'=>$offers,
                   'ads '=>  $ads

             ]
         );


    }

    public function constants(){
        $constants = Constants::all();

        return response()->json(
            ['status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'constants'
                ],
                'constants'=>$constants,
]);

    }


}
