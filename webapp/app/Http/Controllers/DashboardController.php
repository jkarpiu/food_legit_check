<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ToAddProduct;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = ToAddProduct::orderBy('created_at', 'desc')->paginate(3);
        return view('auth.dashboard')->with('products', $products);
    }
}
