<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = ['s_order_type','s_name','s_phone','s_address'
        ,'s_store_address','dt_date','t_time','s_note','i_total','i_user_id'
        ,'i_cart_id'];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function carts()
    {
        return $this->belongsTo(Cart::class,'i_cart_id')->with('product');
    }
}
