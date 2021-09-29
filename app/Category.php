<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $fillable = [
        'name'
    ];
    
    public function sub_categories(){
        return $this->belongsToMany(SubCategory::class, 'category_subcategory','category_id','subcategory_id');
    }
}
