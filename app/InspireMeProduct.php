<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspireMeProduct extends Model
{
    public function variants(){
        return $this->belongsTo('App\Variant','variant_id');
    }
    public function products(){
        return $this->belongsTo('App\Product','product_id');
    }
}
