<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $products = Product::when($search, function ($query) use ($search) {
            $query->where('nama_produk', 'like', "%$search%")
                  ->orWhere('kategori', 'like', "%$search%");
        })->get();

        return view('menu.index', compact('products'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('menu.edit', compact('product'));
    }
}

