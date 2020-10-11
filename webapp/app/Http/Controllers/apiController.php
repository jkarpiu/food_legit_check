<?php

namespace App\Http\Controllers;

use Request;
use App\products;

class apiController extends Controller
{
    public function get() {
        return response() -> json(
            products::where('barcode', $_REQUEST['barcode'])->get()
        );
    }
}
