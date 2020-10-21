<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\userQueries;

class apiController extends Controller
{
    public function get(Request $request)
    {
        if ($_REQUEST['id'] == null)
            $product = Product::where('barcode', $_REQUEST['barcode'])->get();
        else
            $product =  Product::where('id', $_REQUEST['id'])->get();

        if ($product == null)
            return response()->json(404);

        if (Auth::user()) {
            userQueries::create([
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

    public function productsHistory(Request $request) {
        $offset = $request['offset'] != null ? $request['offset'] : 0;
        $limit = $request['limit'];
        return response() -> json(userQueries::where('user_id', Auth::id())->skip($offset)->take(null)->get());
    }

    public function test()
    {
        return response()->json(
            "Parkour!!"
        );
    }
}
