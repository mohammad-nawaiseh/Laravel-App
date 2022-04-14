<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = ['product_name', 'product_description', 'product_price', 'product_image', 'cheese_weight', 'beef_weight', 'onion_weight'];
}
