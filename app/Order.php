<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'shipping_price','expedition_name','service',
        'address_id','payment_id','user_id','image_payment_url'
    ];
    public function address()
    {
        return $this->belongsTo('App\Address');
    }
    public function payment(){
        return $this->belongsTo('App\Payment');
    }
    public function orderdetail(){
        return $this->hasMany('App\OrderDetail');
    }
}
