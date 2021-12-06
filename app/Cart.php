<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function variants(){
        return $this->belongsTo('App\Variant','variant_id');
    }
    public function products(){
        return $this->belongsTo('App\Product','product_id');
    }
    public function variants_sizes(){
        return $this->belongsTo('App\VariantSize','variantsize_id');
    }
}
