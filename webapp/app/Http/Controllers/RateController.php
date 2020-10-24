<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rate;

class RateController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function add(Request $req) {
        if (Auth::user() -> rate) {
            $req->validate([
                'rate_scale' => 'required|numeric|min:0:max:5',
                'content' => 'required|string|max:255:min:4',
            ]);
            $rate = Auth::user() -> rate;
            $rate -> rate_scale = $req -> rate_scale;
            $rate -> content = $req -> content;
            $rate -> save();
        } else {
            $req->validate([
                'rate_scale' => 'required|numeric|min:1:max:5',
                'content' => 'required|string|max:255:min:4',
            ]);
            $rate = new Rate;
            $rate -> user_id = Auth::user()->id;
            $rate -> rate_scale = $req -> rate_scale;
            $rate -> content = $req -> content;
            $rate -> save();
        }
        return view('rated-success');
    }
}
