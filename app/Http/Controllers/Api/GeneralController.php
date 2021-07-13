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
            's_description_'.app()->getLocale() .' as s_description')
            ->take(3)->get();
        $ads = Ads::all();
        $offers =Product::select('id',
            's_name_'.app()->getLocale() .' as s_name',
            's_description_'.app()->getLocale() .' as s_description',
            's_image','b_is_offer','b_is_favorite','f_old_price','f_new_price','i_category_id')
            ->where('b_is_offer','=',true)->take(3)->get();

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

    public function addconstants(Request $request){

        $request->validate([
            's_key' => 'required',
            's_value' => 'required',
        ]);
        $data = $request->all();
        $constants = Constants::create($data);
        return response()->json($constants, 201);

    }

    public function deleteconstants($id){
        $constant = Constants::destroy($id);
        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'deleted done'
            ],
            'constant'=>$constant]);
    }

    public function addAds(Request $request){
        $request->validate([
            's_image' => 'image'
        ]);

        $data = $request->all();

        if($request->hasfile('s_image')) {
            $request->file('s_image')->move(public_path('img/products/'), $request->file('s_image')->getClientOriginalName());
            $data['s_image'] = 'https://newlinetech.site/jourystore/public/img/products/' . $request->file('s_image')->getClientOriginalName();
        }

        $ads = Ads::create($data);
        return response()->json($ads, 201);

    }

    public function destroyAds($id){
        $ads = Ads::destroy($id);
        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'deleted done'
            ],
            'product'=>$ads]);
    }
}
