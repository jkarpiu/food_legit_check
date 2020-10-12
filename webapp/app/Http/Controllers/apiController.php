<?php

namespace App\Http\Controllers;

use Request;
use App\Product;

class apiController extends Controller
{
    public function get() {
        return response() -> json(
            Product::where('barcode', $_REQUEST['barcode'])->get()
        );
    }
}
