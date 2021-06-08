<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constants extends Model
{
    protected $fillable = ['s_key','s_value'];
    use HasFactory;
}
