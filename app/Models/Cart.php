<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['i_user_id','i_total'];


    public function user()
    {
        return $this->belongsTo(User::class,'i_user_id');
    }


    public function items()
    {
        return $this->hasMany(CartDetails::class,'i_cart_id')->with('product');
    }





}
