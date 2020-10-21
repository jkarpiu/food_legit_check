<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userQueries extends Model
{
    protected $fillable = ['user_id', 'product_id', 'eaten'];
}
