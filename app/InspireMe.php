<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspireMe extends Model
{
    protected $fillable = [
        'image_url','user_id','title','caption'
    ];
    public function inspiremeproducts()
    {
        return $this->hasMany(InspireMeProduct::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
