<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['s_name_ar','s_description_ar','s_name_en','s_description_en',
        's_image','f_old_price','i_category_id','s_store_en','s_store_ar'
];

    public function category(){
        return $this->belongsTo(Category::class);
    }


    public function favorite(){
        return $this->belongsTo(Favorite::class,'i_product_id','id')
            ->where('i_user_id',Auth::id());
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class,'i_product_id','id')
            ->where('i_user_id',Auth::id());
    }



//    public function favList(){
//        return $this->favorite()->selectRaw('id','i_product_id')->groupBy('id');
//    }





//    public function product_cart()
//    {
//        return $this->hasMany(Product_Cart::class);
//    }
//
//    public function order_details()
//    {
//        return $this->hasMany(Order_Detail::class);
//    }
}
