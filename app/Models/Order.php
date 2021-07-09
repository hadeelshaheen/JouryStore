<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = ['s_order_type','s_name','s_phone','s_address','s_status'
        ,'s_store_address','dt_date','t_time','s_note','i_total','i_user_id'];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class,'i_user_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetails::class,'i_order_id')
            ->with('products')
        ;
    }

}
