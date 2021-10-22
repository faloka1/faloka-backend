<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'quantity','order_id','variant_id'
    ];
    public function variants(){
        return $this->belongsTo('App\Variant');
    }
}
