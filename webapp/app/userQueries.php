<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userQueries extends Model
{
    protected $fillable = ['user_id', 'product_id', 'eaten'];
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function product (){
        return $this->belongsTo('App\Product');
    }
}
    