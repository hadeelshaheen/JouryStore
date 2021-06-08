<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

  public function listProducts(Request $request){
      $category_id = $request->category_id;
      $product =Product::select('id',
          's_name_'.app()->getLocale() .' as s_name',
          's_description_'.app()->getLocale() .' as s_description',
          's_image','b_is_offer','f_old_price','f_new_price','i_category_id')
         ->where('i_category_id',$category_id)
          ->get();

      return response()->json(
          [

              'status'=>[
                  'success'=>true,
                  'code'=> 1,
                  'message'=>'List of product'

              ],
              'products'=>$product]);
  }

  public function listOffers(){
      $offers =Product::select('id',
          's_name_'.app()->getLocale() .' as s_name',
          's_description_'.app()->getLocale() .' as s_description',
          's_image','b_is_offer','f_old_price','f_new_price','i_category_id')
          ->where('b_is_offer','=',true)
          ->get();

      return response()->json(
          [

              'status'=>[
                  'success'=>true,
                  'code'=> 1,
                  'message'=>'product offers'

              ],
              'offers'=>$offers]);
  }


  public function store(Request $request){
      $request->validate([
          's_name_ar' => 'string',
          's_description_ar' => 'string',
          's_name_en' => 'string',
          's_description_en' => 'string',
          'f_old_price' => 'string',
          'i_category_id' => 'string',
          's_image' => 'image',
          's_store_en' => 'string',
          's_store_ar' => 'string',
          'b_is_offer'=> 'string',
          'f_new_price'=> 'string'
      ]);

      $data = $request->all();

      if ($request->hasFile('s_image') && $request->file('s_image')->isValid()) {
          $data['s_image'] = $request->file('s_image')->store('/', 'public');
      }
      $product = Product::create($data);
      return response()->json($product, 201);
  }

  public function search(Request $request){
      $data = $request->input('word');
      $product =Product::select('id',
          's_name_'.app()->getLocale() .' as s_name',
          's_description_'.app()->getLocale() .' as s_description',
          's_image','b_is_offer','f_old_price','f_new_price','i_category_id')
          ->where('s_name_en', 'like', "%{$data}%")
          ->orWhere('s_name_ar', 'like', "%{$data}%")
          ->get();

      return response()->json(
          [

              'status'=>[
                  'success'=>true,
                  'code'=> 1,
                  'message'=>'search result'

              ],
              'products'=>$product]);
  }

    public function filter(Request $request){
        $is_offer = $request->is_offer;
        $min = $request->min;
        $max = $request->max;
        $category = $request->category_id;

        $product =Product::select('id',
            's_name_'.app()->getLocale() .' as s_name',
            's_description_'.app()->getLocale() .' as s_description',
            's_image','b_is_offer','f_old_price','f_new_price','i_category_id')
            ->where('b_is_offer', 'like', "%{$is_offer}%")
            ->orWhere('f_new_price', 'BETWEEN',$min,'AND',$max)
            ->orWhere('i_category_id','$category')
            ->get();

        return response()->json(
            [

                'status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'filter result'

                ],
                'products'=>$product]);
    }


    public function similarProduct(Request $request){
        $product_id = $request->id;
        $category_id = $request->category_id;

        $product =Product::select('id',
            's_name_'.app()->getLocale() .' as s_name',
            's_description_'.app()->getLocale() .' as s_description',
            's_image','b_is_offer','f_old_price','f_new_price','i_category_id')
            ->where('i_category_id', '=',$category_id)
            ->whereNotIn('id',$product_id)

            ->get();

        return response()->json(
            [

                'status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'Similar Product'

                ],
                'products'=>$product]);
    }

    public function destroy($id){
      $product = Product::destroy($id);
        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'deleted done'
            ],
            'product'=>$product]);
    }
}
