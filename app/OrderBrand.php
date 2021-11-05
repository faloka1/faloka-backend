<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderBrand extends Model
{
    public function shipping(){
        return $this->belongsTo('App\Shipping');
    }
    public function order_details(){
        return $this->hasMany('App\OrderDetail');
    }
}
