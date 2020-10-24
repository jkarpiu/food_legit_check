<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\userQueries;
use App\User;
use Mockery\Undefined;

class apiController extends Controller
{
    public function get(Request $request)
    {
        Auth::shouldUse('api');

        if ($_REQUEST['id'] == null)
            $product = Product::where('barcode', $_REQUEST['barcode'])->get();
        else
            $product =  Product::where('id', $_REQUEST['id'])->get();

        if ($product == null)
            return response()->json(404);
        $user = User::where('id', Auth::id())->get();
        if (Auth::user()) {
            $user[0]->queries()->create([
                'user_id' => Auth::id(),
                'product_id' => $product[0]['id'],
                'eaten' => false
            ]);
        }
        return response()->json($product);
    }
    public function shortSearch()
    {
        return response()->json(
            Product::select('name', 'id')->where('name', 'LIKE', '%' . $_REQUEST['query'] . '%')->take(10)->get()
        );
    }

    public function productsHistory(Request $request)
    {
        $offset = $request['offset'] != null ? $request['offset'] : 0;
        $limit = $request['limit'];
        // return response() -> json(userQueries::first() ->with('product')->get()); 
        return response()->json(userQueries::where('user_id', Auth::id())->orderBy('id', 'desc')->skip($offset)->take($limit)->with('product')->get());
    }

    public function catalog(Request $request)
    {
        $offset = $request['offset'] != null ? $request['offset'] : 0;
        $limit = $request['limit'];
        $category = $request['category'];
        if ($category) {
            $response = Product::where('category', $category)->orderBy('name', 'asc')->skip($offset)->take($limit)->get();
        } else {
            $response = Product::orderBy('name', 'asc')->skip($offset)->take($limit)->get();
        }
        return response()->json($response);
    }

    public function test()
    {
        return response()->json(
            "Parkour!!"
        );
    }
}
