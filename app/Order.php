<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'shipping_price','expedition_name','service',
        'address_id','payment_id','user_id'
    ];
}
