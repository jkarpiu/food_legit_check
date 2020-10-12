<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class SingleProductController extends Controller
{
    public function index($id)
    {
        $product = Product::where('id', $id)->firstOrFail();

        return view('singleProduct', compact('product'));
    }
}
