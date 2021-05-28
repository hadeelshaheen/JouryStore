<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = Favorite::with('product')
                ->where('i_user_id',Auth::id())
            ->orderBy('created_at','desc')
            ->get();

        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'favorite products'
            ],
            'favorite'=>$favorites]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $favorite =   Favorite::create(['i_product_id'=>$request->input('i_product_id'),
              'i_user_id'=>Auth::id()]);

        return response()->json([
                'status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'done'
                ],
                'favorite'=>$favorite]);




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $favorite_id = $request->favorite_id;
        $favorite = Favorite::destroy($favorite_id);
        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'deleted done'
            ],
            'favorite'=>$favorite]);

    }
}
