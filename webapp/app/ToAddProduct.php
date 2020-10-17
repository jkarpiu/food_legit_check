<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToAddProduct extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'barcode';
    public $incrementing = true;
}
