<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'address_id','payment_id','user_id','image_payment_url'
    ];
    public function address()
    {
        return $this->belongsTo('App\Address');
    }
    public function payment(){
        return $this->belongsTo('App\Payment');
    }
    public function order_details(){
        return $this->hasMany('App\OrderDetail');
    }
}
