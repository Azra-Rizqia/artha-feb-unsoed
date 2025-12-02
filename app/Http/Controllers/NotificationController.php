<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationController extends Controller
{
    // Private property untuk simulasi database
    private function getDummyNotifications()
    {
        return [
            [
                'id' => 1,
                'title' => 'Pesanan #ORD-001 Selesai',
                'body' => 'Pesanan makan di tempat atas nama Budi telah selesai diproses dan siap disajikan. Silakan panggil pelanggan untuk mengambil pesanan atau antarkan ke meja nomor 5.',
                'created_at' => Carbon::now()->subMinutes(5),
                'is_read' => false,
                'type' => 'order' // Tipe untuk ikon (opsional)
            ],
            [
                'id' => 2,
                'title' => 'Stok Ayam Habis',
                'body' => 'Peringatan: Stok bahan baku "Daging Ayam" sudah mencapai batas minimum (0 kg). Segera lakukan restock untuk menghindari penolakan pesanan pelanggan.',
                'created_at' => Carbon::now()->subHours(2),
                'is_read' => false,
                'type' => 'stock'
            ],
            [
                'id' => 3,
                'title' => 'Pembayaran Diterima',
                'body' => 'Pembayaran via QRIS sebesar Rp 150.000 telah berhasil diverifikasi dan masuk ke saldo kas harian. ID Transaksi: QRIS-99887766.',
                'created_at' => Carbon::yesterday()->setHour(14)->setMinute(30),
                'is_read' => true,
                'type' => 'payment'
            ],
            [
                'id' => 4,
                'title' => 'Update Sistem',
                'body' => 'Fitur baru "Laporan Keuangan Harian" sekarang sudah tersedia di menu profil. Anda kini bisa mengunduh laporan dalam format PDF dan Excel.',
                'created_at' => Carbon::now()->subDays(3),
                'is_read' => true,
                'type' => 'system'
            ],
            [
                'id' => 5,
                'title' => 'Selamat Datang di Artha',
                'body' => 'Akun anda berhasil dibuat. Silahkan lengkapi data profil kantin anda untuk mulai berjualan.',
                'created_at' => Carbon::now()->subDays(7),
                'is_read' => true,
                'type' => 'system'
            ],
        ];
    }

    public function index()
    {
        $notifications = $this->getDummyNotifications();
        return view('notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        // Cari notifikasi berdasarkan ID dari data dummy
        $notification = collect($this->getDummyNotifications())->firstWhere('id', $id);

        if (!$notification) {
            abort(404); // Tampilkan 404 jika tidak ketemu
        }

        return view('notifications.show', compact('notification'));
    }
}