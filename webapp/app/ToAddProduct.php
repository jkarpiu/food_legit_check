<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToAddProduct extends Model
{
    protected $table = 'approvements';
    public $timestamps = true;
    protected $primaryKey = 'product_id';
    public $incrementing = true;
}
