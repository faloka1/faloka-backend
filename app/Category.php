<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];
    protected $hidden = [
        'pivot'
    ];
    public function sub_categories(){
        return $this->belongsToMany(SubCategory::class)->withPivot('image_url');
    }
    public function carousels()
    {
        return $this->hasMany('App\Carousel');
    }
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}
