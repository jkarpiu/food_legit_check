<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Report;
use App\ToAddProduct;
use App\Illness;

class ProductsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['index', 'find', 'search', 'categories']]);
    }

    public function index() {
        $products = Product::orderBy('name', 'asc')->paginate(100);
        $labels = Product::orderBy('category', 'asc')->get()->unique('category');
        return view('catalog', compact('products', 'labels'));
    }

    public function find($id) {
        $product = Product::find($id);
        $illness_ids = explode(",", $product -> illness);
        $illness_contents = [];
        foreach ($illness_ids as $ill) {
            $a = array(Illness::find($ill)->titles0, Illness::find($ill)->content);
            array_push($illness_contents, $a);
        }
        $illness = $illness_contents;
        // dd($illness);
        return view('singleProduct', compact('product', 'illness'));
    }

    public function add($id) {
        if (Auth::user() -> role == 'Administrator') {
            $approvement = ToAddProduct::find($id);
            $approvement -> is_approved = True;
            $approvement -> save();
            $product = new Product();
            $product -> category = $approvement -> category;
            $product -> name = $approvement -> name;
            $product -> barcode = $approvement -> barcode;
            $product -> image = $approvement -> image;
            $product -> components = $approvement -> components;
            $product -> illness = $approvement -> effects;
            $product -> price = $approvement -> price;
            $product -> save();
            return redirect('/product/'.$product -> id);
        } else {
            return redirect(url()->previous());
        }
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

    public function edit(Request $req) {
        $req->validate([
            'name' => 'required',
            'barcode' => 'nullable|numeric',
            'price' => ['required', 'regex:/^[0-9][0-9]{0,2}[.|,][0-9][0-9]$/'],
            'components' => 'nullable|max:1000|string',
            'image' => 'nullable|image|max:2048',
        ]);
        $product = Product::find($req -> id);
        $product -> category = $req -> categories;
        $product -> name = $req -> name;
        $product -> barcode = $req -> barcode;
        if($req -> image != null) {
            $img_name = Str::random(30);
            $extension = $req -> image -> extension();
            $req -> image -> storeAs('/public', $img_name.".".$extension);
            $url = Storage::url($img_name.".".$extension);
            $product -> image = $url;
        }
        $product -> components = $req -> components;
        $product -> price = $req -> price;
        $product -> save();
        return redirect('/product/'.$product -> id);
    }

    public function delete($id) {
        if (Auth::user()->role == 'Administrator') {
            Product::find($id)->delete();
        }
        return redirect('/catalog');
    }

    public function reportSite($id) {
        $product_id = $id;
        return view('report-product', compact('product_id'));
    }

    public function report(Request $req) {
        $report = new Report;
        $report -> user_id = Auth::user()->id;
        $report -> product_id = $req -> product_id;
        $report -> content = $req -> content;
        $report -> save();
        return redirect('/product/'.$req -> product_id);
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
