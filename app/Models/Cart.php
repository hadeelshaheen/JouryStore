<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['i_product_id','i_user_id','i_quantity','i_price','i_total'];


    public function user()
    {
        return $this->belongsTo(User::class,'i_user_id');
    }

        public function product(){
        return $this->belongsTo(Product::class,'i_product_id')
            ->select('id',
                's_name_'.app()->getLocale() .' as s_name',
                's_description_'.app()->getLocale() .' as s_description',
                's_image','b_is_offer','f_old_price','f_new_price','i_category_id')
            ;
    }
    public function order()
    {
        return $this->hasOne(Order::class);
    }

}
