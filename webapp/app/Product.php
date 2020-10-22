<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    public function userQuries() {
        return $this->hasMany('App\UserQuries');
    }
}
