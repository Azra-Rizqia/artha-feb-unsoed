<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::withCount('items')->latest();

        if ($request->filled('search')) {
            $query->where('order_code', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pemesan', 'like', '%' . $request->search . '%');
        }

        // PERBAIKAN 1: Pakai paginate biar web ga berat kalau data banyak
        $orders = $query->paginate(10); 

        return view('orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('kategori', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $products = $query->where('stock', '>', 0)->latest()->get();

        // PERBAIKAN 2: Hapus logic generate orderCode disini.
        // Kita generate nanti pas SAVE aja biar ga bentrok antar kasir.
        
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|string',
            'nama_pemesan' => 'required|string',
            'tipe_pesanan' => 'required|in:makan_ditempat,bungkus',
            'payment_method' => 'required|in:tunai,qris',
        ]);

        $cartItems = json_decode($request->cart, true);

        if (empty($cartItems)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        try {
            DB::transaction(function () use ($request, $cartItems) {
                
                // PERBAIKAN 3: Generate Order Code disini (inside transaction)
                // Ini memastikan urutan nomor tidak balapan/bentrok
                $today = date('Ymd');
                // Lock row terakhir untuk memastikan sequence aman (opsional tapi bagus)
                $lastOrder = Order::whereDate('created_at', now())->lockForUpdate()->count();
                $count = $lastOrder + 1;
                $orderCode = 'ORD-' . $today . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

                $order = Order::create([
                    'order_code' => $orderCode, // Pakai kode yang baru digenerate
                    'nama_pemesan' => $request->nama_pemesan,
                    'tipe_pesanan' => $request->tipe_pesanan,
                    'payment_method' => $request->payment_method,
                    'total_uang_masuk' => 0,
                    'total_modal' => 0,
                    'total_profit' => 0,
                    'status' => 'selesai'
                ]);

                $total_uang = 0;
                $total_modal = 0;
                $total_profit = 0;

                foreach ($cartItems as $item) {
                    // Lock produk biar stok ga berubah pas lagi diproses transaksi lain
                    $product = Product::lockForUpdate()->findOrFail($item['id']);
                    
                    // PERBAIKAN 4: Cek Stok Cukup Gak?
                    if ($product->stock < $item['qty']) {
                        throw new \Exception("Stok {$product->nama_produk} tidak cukup! Sisa: {$product->stock}");
                    }

                    $subtotal = $product->harga_jual * $item['qty'];
                    $modal = $product->harga_modal * $item['qty'];
                    $profit = ($product->harga_jual - $product->harga_modal) * $item['qty'];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'jumlah' => $item['qty'],
                        'harga_modal' => $product->harga_modal,
                        'harga_jual' => $product->harga_jual,
                        'subtotal' => $subtotal,
                        'profit' => $profit,
                    ]);

                    $product->decrement('stock', $item['qty']);

                    $total_uang += $subtotal;
                    $total_modal += $modal;
                    $total_profit += $profit;
                }

                $order->update([
                    'total_uang_masuk' => $total_uang,
                    'total_modal' => $total_modal,
                    'total_profit' => $total_profit,
                ]);
            });

            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            // Tangkap error stok atau error lain
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }
}