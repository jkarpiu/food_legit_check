<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ToAddProduct;
use Illuminate\Support\Facades\Auth;
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
    public function index() {
        if (Auth::user()->role == 'Admin') {
            $products = ToAddProduct::orderBy('created_at', 'desc')->paginate(3);
        } else {
            $products = Auth::user()->approvements()->paginate(3);
        }
        return view('auth.dashboard')->with('products', $products);
    }
}
