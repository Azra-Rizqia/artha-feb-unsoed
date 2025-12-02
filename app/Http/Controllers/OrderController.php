<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource with optional filter
     */
    public function getAll(Request $request)
    {
        $query = Order::with('items.product')->latest();

        // Filter berdasarkan query parameter
        if ($request->has('filter')) {
            $filter = $request->filter;

            if ($filter === 'today') {
                $query->whereDate('created_at', now()->toDateString());
            } elseif ($filter === 'this_week') {
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($filter === 'this_month') {
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
            }
        }

        $orders = $query->get();

        // Tambahkan formatted_id
        $orders->transform(function ($order) {
            $order->formatted_id = 'Pesanan ID #' . str_pad($order->id, 3, '0', STR_PAD_LEFT);
            return $order;
        });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Generate a new order code for "Create Orders" page
     */
    public function getNewOrderCode()
    {
        $totalOrders = Order::count() + 1; // +1 untuk order berikutnya
        $formattedId = str_pad($totalOrders, 2, '0', STR_PAD_LEFT);

        return response()->json([
            'success' => true,
            'formatted_id' => 'Pesanan ID #' . $formattedId, // untuk FE
            'order_code' => 'ORD-' . date('Ymd') . '-' . $formattedId // untuk DB saat submit
        ]);
    }

    /**
     * Store a newly created order
     */
    public function addOrders(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string',
            'tipe_pesanan' => 'required|in:makan_ditempat,bungkus',
            'payment_method' => 'required|in:tunai,qris',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'order_code' => 'required|string', // harus dikirim dari FE
        ]);

        // Pakai kode yang dikirim dari FE
        $orderCode = $request->order_code;

        $order = Order::create([
            'order_code' => $orderCode,
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

        foreach ($request->items as $item) {
            $produk = Product::findOrFail($item['product_id']);

            $subtotal = $produk->harga_jual * $item['jumlah'];
            $modal = $produk->harga_modal * $item['jumlah'];
            $profit = ($produk->harga_jual - $produk->harga_modal) * $item['jumlah'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $produk->id,
                'jumlah' => $item['jumlah'],
                'harga_modal' => $produk->harga_modal,
                'harga_jual' => $produk->harga_jual,
                'subtotal' => $subtotal,
                'profit' => $profit,
            ]);

            $produk->stock -= $item['jumlah'];
            $produk->save();

            $total_uang += $subtotal;
            $total_modal += $modal;
            $total_profit += $profit;
        }

        $order->update([
            'total_uang_masuk' => $total_uang,
            'total_modal' => $total_modal,
            'total_profit' => $total_profit,
        ]);

        // Tambahkan formatted_id di response
        $order->formatted_id = 'Pesanan ID #' . substr($orderCode, -2); // ambil urutan dari kode

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'data' => $order->load('items.product')
        ], 201);
    }

    /**
     * Display a specific order by ID
     */
    public function getByIdOrders(string $id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        $order->formatted_id = 'Pesanan ID #' . str_pad($order->id, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }


    /**
     * Cancel order
     */
    public function batalOrders(string $id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->status === 'batal') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan sudah dibatalkan sebelumnya!'
            ], 400);
        }

        foreach ($order->items as $item) {
            $produk = Product::find($item->product_id);
            if ($produk) {
                $produk->stock += $item->jumlah;
                $produk->save();
            }
        }

        $order->update([
            'status' => 'batal'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibatalkan dan stok telah dikembalikan'
        ]);
    }
}
