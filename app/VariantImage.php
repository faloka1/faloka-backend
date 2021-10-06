<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariantImage extends Model
{
    public function variants(){
        return $this->belongsTo(Variant::class,'variant_id');
    }
}
