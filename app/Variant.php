<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    public function products(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function variants_image()
    {
        return $this->hasMany('App\VariantImage');
    }
    public function variants_sizes()
    {
        return $this->hasMany('App\VariantSize');
    }
}
