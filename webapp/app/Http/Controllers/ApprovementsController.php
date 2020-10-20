<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ToAddProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApprovementsController extends Controller
{
    public function index() {
        $products = ToAddProduct::orderBy('created_at', 'desc')->get();
        return view('approve-products', compact('products'));
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
        return view('singleApprove', compact('product'));
    }

    public function delete($id) {
        $product = ToAddProduct::find($id);
        $product -> delete();
        return redirect('/dashboard/approve');
    }

    public function edit(Request $req) {
        // dd($req);
        $price = $req -> price;
        $id = $req -> product_id;
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
