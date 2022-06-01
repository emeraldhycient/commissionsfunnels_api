<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

   protected $fillable = [
        'product_id',
        'product_name',
        'product_description',
        'product_price',
        'product_image',
        'product_category',
        'product_quantity',
        'product_commission',
        'product_seller',
        'sales_copy',
        'product_delivery',
    ];
}