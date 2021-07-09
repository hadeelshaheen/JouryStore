<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetails;
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
    public function index(){

        $cart = Cart::with('items')
            ->where('i_user_id',Auth::id())
            ->get();

        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'Cart list'
            ],
            'cart'=>$cart,
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
        $product_id = $request->i_product_id;
        $product = Product::find($product_id);
        $price = $product->f_new_price;
        $quantity = $request->i_quantity;
        $total = $price * $quantity ;

        $cart = Cart::where('i_user_id',Auth::id())->first();

        if ($cart == null) {
            $cart = Cart::create([
                'i_user_id' =>Auth::id()
            ]);
            $cartItem = CartDetails::create([
                'i_cart_id'=>$cart->id,
                'i_product_id'=>$product_id,
                'i_price'=>$price,
                'i_quantity'=>$quantity,
                'i_total'=>$total,
            ]);

            //update total
            $sum = CartDetails::where('i_cart_id',$cart->id)->sum('i_total');
            $cart->i_total = $sum;
            $cart->save();

            return response()->json([
                'status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'Add to cart']]);
        }
        else{
            $cartItem = CartDetails::where('i_product_id',$product_id)->first();
            if ($cartItem == null){
                $cartItem = CartDetails::create([
                    'i_cart_id'=>$cart->id,
                    'i_product_id'=>$product_id,
                    'i_price'=>$price,
                    'i_quantity'=>$quantity,
                    'i_total'=>$total,
                ]);

                //update total
                $sum = CartDetails::where('i_cart_id',$cart->id)->sum('i_total');
                $cart->i_total = $sum;
                $cart->save();

                return response()->json([
                    'status'=>[
                        'success'=>true,
                        'code'=> 1,
                        'message'=>'Add to cart'
                    ]]);

            }else{
                $cartItem->i_quantity = $quantity;
                $cartItem->i_total = $total;
                $cartItem->save();

                //update total
                $sum = CartDetails::where('i_cart_id',$cart->id)->sum('i_total');
                $cart->i_total = $sum;
                $cart->save();

                return response()->json([
                    'status'=>[
                        'success'=>true,
                        'code'=> 1,
                        'message'=>'update cart'
                    ]]);
            }
        }
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
        $cart_item_id = $request->cart_item_id;
        $cart = CartDetails::destroy($cart_item_id);

        //update total
        $cart = Cart::where('i_user_id',Auth::id())->first();
        $sum = CartDetails::where('i_cart_id',$cart->id)->sum('i_total');
        $cart->i_total = $sum;
        $cart->save();

        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'deleted done'
            ]]);
    }
}
