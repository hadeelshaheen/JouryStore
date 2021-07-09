<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['s_name_ar','s_description_ar','s_name_en','s_description_en',
        's_image','b_is_offer','b_is_favorite','f_new_price','f_old_price','i_category_id','s_store_en','s_store_ar'
];

    public function category(){
        return $this->belongsTo(Category::class);
    }


    public function favorite(){
        return $this->belongsTo(Favorite::class,'i_product_id','id')
            ->where('i_user_id',Auth::id());
    }

        public function product_cart()
    {
        return $this->belongsToMany(CartDetails::class);
    }


    public function product_order()
    {
        return $this->belongsToMany(OrderDetails::class);
    }



}
