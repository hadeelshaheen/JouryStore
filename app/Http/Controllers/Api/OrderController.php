<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
        $order = Order::with('carts')
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
        $i_cart_id = $request->i_cart_id;

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
           'i_user_id'=>Auth::id() ,
           'i_cart_id'=>$i_cart_id ,

        ]);

        return response()->json(
            [

                'status'=>[
                    'success'=>true,
                    'code'=> 1,
                    'message'=>'created order'

                ],
                'order'=>$order]);


    }



}
