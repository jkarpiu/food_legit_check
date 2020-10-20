<?php

namespace App\Http\Controllers;

use Request;
use App\Product;

class apiController extends Controller
{
    public function get() {
            if ($_REQUEST['id'] == null){
        return response() -> json(
                Product::where('barcode', $_REQUEST['barcode'])->get()
        );}else
        return response() -> json(
                Product::where('id', $_REQUEST['id'])->get()
        );
    }
    public function shortSearch() {
        return response() -> json(
            Product::select('name', 'id')->where('name', 'LIKE', '%'.$_REQUEST['query'].'%')->take(10)->get()
        );
    }
    public function test() {
        return response() -> json(
            "Parkour!!"
        );
    }
}

