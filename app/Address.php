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
}
