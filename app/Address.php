<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'name','phone_number','province',
        'district','sub_district','postal_code',
        'location'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function districts()
    {
        return $this->hasOne('App\District','district_id','district_id');
    }
    public function provinces()
    {
        return $this->hasOne(Province::class, 'province_id','province_id');
    }
}
