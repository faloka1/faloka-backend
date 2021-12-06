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
    public function order(){
        return $this->belongsTo('App\Order','order_id');
    }
    public function variants_sizes(){
        return $this->belongsTo('App\VariantSize','variantsize_id');
    }
}
