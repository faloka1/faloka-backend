<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','description','slug','brand_id'
    ];
    public function categories(){
        return $this->belongsToMany('App\Category');
    }
    public function sub_categories(){
        return $this->belongsTo('App\SubCategory');
    }
    public function brands(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function variants()
    {
        return $this->hasMany('App\Variant');
    }
}