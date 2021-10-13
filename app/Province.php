<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function districts(){
        return $this->hasMany('App\District');
    }
}
