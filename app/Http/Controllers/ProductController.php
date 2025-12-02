<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('menu.index', compact('products'));
    }
    // ------------------------
    // CREATE PRODUCT
    // ------------------------
     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'kategori' => 'required',
            'stock' => 'required|integer',
            'harga_modal' => 'required|integer',
            'persen_keuntungan' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload image & simpan ke image_url
        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('produk', 'public');
        }

        // hitung harga jual
        $validated['harga_jual'] =
            $validated['harga_modal'] +
            ($validated['harga_modal'] * ($validated['persen_keuntungan'] / 100));

        // Hapus field 'image' agar tidak masuk ke DB
        unset($validated['image']);

        $product = Product::create($validated);

        // tambahkan full URL
        $product->image_url = $product->image_url
            ? asset('storage/' . $product->image_url)
            : null;

        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ]);
    }

    // ------------------------
    // SHOW PRODUCT
    // ------------------------
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        $product->image_url = $product->image_url
            ? asset('storage/' . $product->image_url)
            : null;

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    public function searchProducts(Request $request)
    {
        $query = Product::query();

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where('nama_produk', 'like', "%{$keyword}%")
                ->orWhere('kategori', 'like', "%{$keyword}%");
        }

        $products = $query->get();

        foreach ($products as $product) {
            $product->image_url = $product->image_url
                ? asset('storage/' . $product->image_url)
                : null;
        }

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }


    // ------------------------
    // UPDATE PRODUCT
    // ------------------------
    public function updateProduct(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'sometimes|required|string',
            'deskripsi' => 'sometimes|required|string',
            'kategori' => 'sometimes|required|string',
            'harga_modal' => 'sometimes|required|numeric',
            'persen_keuntungan' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // update image
        if ($request->hasFile('image')) {

            // hapus lama
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }

            // simpan baru
            $validated['image_url'] = $request->file('image')->store('produk', 'public');
        }

        // hitung harga jual jika modal/profit berubah
        if ($request->filled('harga_modal') || $request->filled('persen_keuntungan')) {
            $modal = $request->harga_modal ?? $product->harga_modal;
            $profit = $request->persen_keuntungan ?? $product->persen_keuntungan;

            $validated['harga_jual'] = $modal + ($modal * $profit / 100);
        }

        unset($validated['image']);

        $product->update($validated);

        // full url
        $product->image_url = $product->image_url
            ? asset('storage/' . $product->image_url)
            : null;

        return response()->json([
            'success' => true,
            'message' => 'Produk diperbarui',
            'data' => $product
        ]);
    }

    // ------------------------
    // DELETE
    // ------------------------
    public function deleteProduct(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}
