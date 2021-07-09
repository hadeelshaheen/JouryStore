<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetails extends Model
{
    use HasFactory;

    protected $fillable = ['i_cart_id','i_product_id','i_quantity','i_price','i_total'];


    public function cart()
    {
        return $this->belongsTo(Cart::class,'i_cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'i_product_id')
            ->select('id',
                's_name_'.app()->getLocale() .' as s_name',
                's_store_'.app()->getLocale() .' as s_store',
                's_description_'.app()->getLocale() .' as s_description',
                's_image','b_is_offer','b_is_favorite','f_old_price','f_new_price','i_category_id')
            ;
    }
}
