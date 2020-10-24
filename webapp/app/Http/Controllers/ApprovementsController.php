<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ToAddProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApprovementsController extends Controller
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

    public function index() {
        if (Auth::user()-> role == 'Admin') {
            $products = ToAddProduct::orderBy('created_at', 'desc')->get();
        } else {
            $products = Auth::user()->approvements;
        }
        return view('approve-products', compact('products'));
    }

    public function addSite() {
        return view('add-product');
    }

    public function add(Request $req) {
        $price = $req -> price;
        $price = Str::replaceArray(',', ['.'], $price);
            $req->validate([
                'name' => 'required',
                'barcode' => 'nullable|numeric',
                'price' => ['required', 'regex:/^[0-9][0-9]{0,2}[.|,][0-9][0-9]$/'],
                'components' => 'nullable|max:1000|string',
                'effects' => 'nullable|max:255',
                'image' => 'required|image|max:2048',
            ]);
        $img_name = Str::random(30);
        $extension = $req -> image -> extension();
        $req -> image -> storeAs('/public', $img_name.".".$extension);
        $url = Storage::url($img_name.".".$extension);
        $product = new ToAddProduct;
        $product -> user_id = Auth::user()->id;
        $product -> category = 'Inne';
        $product -> name = $req -> name;
        $product -> barcode = $req -> barcode;
        $product -> image = $url;
        $product -> components = $req -> components;
        $product -> effects = $req -> effects;
        $product -> price = $price;
        $product -> save();
        return view('success');
    }

    public function find($id) {
            $product = ToAddProduct::find($id);
            if (Auth::user()->role == 'Admin' or $product->user->id == Auth::user()->id) {
                return view('singleApprove', compact('product'));
            } else {
                return redirect('/dashboard/approve');
            }
    }

    public function delete($id) {
        if (Auth::user() -> role == 'Admin') {
            $product = ToAddProduct::find($id);
            $product -> delete();
        }
        return redirect('/dashboard/approve');
    }

    public function edit(Request $req) {
        $price = $req -> price;
        $price = Str::replaceArray(',', ['.'], $price);
        $req->validate([
            'name' => 'required',
            'barcode' => 'nullable|numeric',
            'price' => ['required', 'regex:/^[0-9][0-9]{0,2}[.|,][0-9][0-9]$/'],
            'components' => 'nullable|max:1000|string',
            'effects' => 'nullable|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
        $product = ToAddProduct::find($req -> id);
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
        $product -> effects = $req -> effects;
        $product -> price = $price;
        $product -> save();
        return redirect('/dashboard/approve/'.$product -> product_id);
    }

}
