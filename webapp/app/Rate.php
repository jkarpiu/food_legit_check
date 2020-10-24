<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'rates';

    public function user() {
        return $this->belongsTo('App\User');
    }
}
