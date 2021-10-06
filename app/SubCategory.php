<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'name'
    ];
    public function products()
    {
        return $this->belongsToMany('App\Product', 'categories_sub_categories', 'subcategory_id', 'category_id');
    }
}
