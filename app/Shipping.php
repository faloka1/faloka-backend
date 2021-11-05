<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shipping extends Model
{
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function order_details(){
        return $this->hasMany('App\OrderDetail');
    }
}
