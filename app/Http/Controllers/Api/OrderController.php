<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetails;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        $order = Order::with('details')
            ->where('i_user_id',Auth::id())
            ->get();

        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'user orders'
            ],
            'orders'=>$order]);
    }

    public function store(Request $request){
        $s_order_type = $request->s_order_type;
        $s_name = $request->s_name;
        $s_phone = $request->s_phone;
        $s_address = $request->s_address;
        $dt_date = $request->dt_date;
        $t_time = $request->t_time;
        $s_note = $request->s_note;
        $s_store_address = $request->s_store_address;
        $i_total = $request->i_total;
        $cart_id = $request->cart_id;

        $order = Order::create([
           's_order_type'=>$s_order_type ,
           's_name'=>$s_name ,
           's_phone'=>$s_phone ,
           's_address'=>$s_address,
           'dt_date'=>$dt_date ,
           't_time'=>$t_time ,
           's_note'=>$s_note ,
            's_store_address'=>$s_store_address,
            'i_total'=>$i_total ,
           'i_user_id'=>Auth::id()
        ]);

        $cart = Cart::with('items')
            ->where('i_user_id',Auth::id())
            ->get();

        //add order items
        foreach ($cart as $usercart){
            $products =  $usercart->items;
            foreach ($products as $product ) {
              $orderDetails = OrderDetails::create([
                  'i_order_id'=>$order->id,
                  'i_product_id'=>$product->i_product_id,
                  'i_quantity'=>$product->i_quantity,
                  'i_price'=>$product->i_price,
                  'i_total'=>$product->i_total
              ])  ;
       }
        }

        //delete cart items
        $cart_id = $request->cart_id;
        $cart = Cart::destroy($cart_id);
        return response()->json(
            [

                'status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'created order'

                ],
                'order'=>$order->details]);
    }
    public function update(Request $request ,$id){
        $order = Order::findOrFail($id);
        if($order) {
            $order->s_status = $request->s_status;
            $order->save();
            return response()->json([
                'status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'deleted done'
                ],
                'order'=>$order]);
        }
    }

    public function destroy(Request $request){
        $order_id = $request->order_id;
        $order = Order::destroy($order_id);
        return response()->json([
            'status'=>[
                'success'=>true,
                'code'=> 1,
                'message'=>'deleted done'
            ]]);
    }

}
