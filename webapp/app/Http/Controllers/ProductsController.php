<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function index() {
        $products = Product::orderBy('name', 'asc')->paginate(100);
        $labels = Product::orderBy('category', 'asc')->get()->unique('category');
        return view('catalog', compact('products', 'labels'));
    }

    public function search() {
        $search = $_GET['query'];
        $products = Product::where('name', 'LIKE', '%'.$search.'%')->paginate(100);
        return view('home', compact('products', 'search'));
    }

    public function category() {

    }
}
