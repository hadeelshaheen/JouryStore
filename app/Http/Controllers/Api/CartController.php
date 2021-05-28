<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeneralTraits;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total =Cart::where('i_user_id', Auth::id())->sum('i_total');
        //dd($total);
        $cart = Cart::with('product')
            ->where('i_user_id', auth()->user()->id)
            ->orderBy('created_at','desc')
            ->get();

        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'Cart list'
            ],
            'cart'=>$cart,
            'Total'=>$total
            ]);


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
    public function store(Request $request){

        $product = Product::find($request->input('i_product_id'));
        $price = $product->f_new_price;
        $quantity = $request->input('i_quantity');
        $total = $price * $quantity ;

        $cart = Cart::create(['i_product_id'=>$request->input('i_product_id'),
            'i_user_id'=>Auth::id(),
            'i_quantity'=>$quantity,
            'i_price'=>$price,
            'i_total'=>$total
            ]);

        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'Add to cart'
            ],
            'cart'=>$cart]);


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
//    public function update(Request $request, $cart_id)
//    {
//        $cart = Cart::find($cart_id);
//        $cart->i_quantity = $request->input('i_quantity');
//        $cart->save();
//
//        return response()->json(['status' => 'true',
//            'message' => 'cart updated !',
//            'user' => $cart]);
//
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cart_id = $request->cart_id;
        $cart = Cart::destroy($cart_id);

        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'deleted done'
            ],
            'cart'=>$cart]);
    }
}
