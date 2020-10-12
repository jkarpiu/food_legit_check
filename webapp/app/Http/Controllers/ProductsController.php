<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name', 'desc')->limit(100)->get();
        return view('catalog', compact('products'));
    }
}
