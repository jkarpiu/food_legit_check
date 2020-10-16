<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    public function index() {
        $products = Product::orderBy('name', 'asc')->simplePaginate(100);
        $labels = Product::orderBy('category', 'asc')->get()->unique('category');
        return view('catalog', compact('products', 'labels'));
    }

    public function search() {
        $search = $_GET['query'];
        $products = Product::where('name', 'LIKE', '%'.$search.'%')->paginate(100);
        return view('home', compact('products', 'search'));
    }

    public function categories($q) {
        $products = Product::where('category', 'LIKE', $q)->paginate(100);
        $labels = Product::orderBy('category', 'asc')->get()->unique('category');
        return view('catalog', compact('products', 'labels'));
    }

    // public function load_data(Request $request) {
    //     if ($request->ajax()) {
    //         if ($request-> id > 0) {
    //             $data = Product::where('id', '<', $request->id)->orderBy('name', 'asc')->limit(100)->get();
    //         } else {
    //             $data = Product::orderBy('name', 'asc')->limit(100)->get();
    //         }
    //         $output = '';
    //         $last_id = '';
    //         if (!$data->isEmpty()) {
    //             foreach($data as $row) {
    //                 $output .='
    //                 <section class="single-product-outer '.$row->category.'">
    //                     <a href="/product/'.$row->id.'">
    //                         <div class="img-box">
    //                             <img src="'.$row->image.'" alt="">
    //                         </div>
    //                         <div class="single-product-inner">
    //                             <h3>'.$row->name.'</h3>
    //                             <h5>Kod kreskowy: '.$row->barcode.'</h5>
    //                             <h4>Cena: '.$row->price.' zł</h4>
    //                         </div>
    //                     </a>
    //                 </section>
    //                 ';
    //                 $last_id = $row->id;
    //             }
    //             $output .= '
    //             <article class="ShowMore">
    //                 <button type="button" name="load_more" id="load_more" data-id="'.$last_id.'" >Pokaż więcej</button>
    //             </article>
    //             ';
    //         } else {
    //             $output = '';
    //         }
    //         echo $output;
    //     }
    // }
}
