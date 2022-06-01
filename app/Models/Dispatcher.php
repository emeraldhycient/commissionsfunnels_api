<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatcher extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'company_name',
        'company_address',
        'company_phone',
        'company_email',
        'company_website',
        'company_images',
        'company_representative',
        'company_representative_phone',
        'delivery_fee',
        'company_location',
        'company_delivery_zone',
        'user_id',
        'next_payment_date'
    ];

    protected $casts = [
        'company_images' => 'array',
    ];
}