<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

protected $fillable = ['s_name_ar','s_description_ar','s_name_en','s_description_en','s_image'
];
    public function products(){
        return $this->hasMany(Product::class);
    }
}
