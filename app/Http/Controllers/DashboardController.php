<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Ringkasan Hari Ini (Dummy)
        $stats = [
            'income' => 1250000, // Rp 1.250.000
            'orders' => 42,      // 42 Transaksi
            'sold_items' => 86,  // 86 Menu Terjual
            'is_open' => true,   // Status Toko Buka
        ];

        // Menu Favorit Hari Ini
        $topProducts = [
            ['name' => 'Ayam Geprek Jumbo', 'sold' => 24, 'image' => 'ayam.jpg'],
            ['name' => 'Es Teh Manis', 'sold' => 50, 'image' => 'esteh.jpg'],
            ['name' => 'Mie Goreng Spesial', 'sold' => 12, 'image' => 'mie.jpg'],
        ];

        // Pesanan Terbaru (Live Feed Simulation)
        $recentOrders = [
            [
                'code' => 'ORD-001',
                'customer' => 'Meja 4 (Budi)',
                'total' => 45000,
                'time' => Carbon::now()->subMinutes(5),
                'status' => 'success'
            ],
            [
                'code' => 'ORD-002',
                'customer' => 'Bungkus (Siti)',
                'total' => 28000,
                'time' => Carbon::now()->subMinutes(12),
                'status' => 'pending'
            ],
            [
                'code' => 'ORD-003',
                'customer' => 'Meja 1 (Rian)',
                'total' => 115000,
                'time' => Carbon::now()->subMinutes(30),
                'status' => 'success'
            ],
        ];

        return view('dashboard.index', compact('stats', 'topProducts', 'recentOrders'));
    }
}