<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'quantity','order_id','variant_id','product_id'
    ];
    public function variants(){
        return $this->belongsTo('App\Variant','variant_id');
    }
    public function products(){
        return $this->belongsTo('App\Product','product_id');
    }
}
