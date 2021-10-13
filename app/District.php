<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function provinces(){
        return $this->belongsTo('App\Province', 'province_id', 'province_id');
    }
}
