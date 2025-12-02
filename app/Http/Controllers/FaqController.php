<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = [
            [
                'category' => 'Tentang Aplikasi',
                'items' => [
                    [
                        'question' => 'Apa itu Artha?',
                        'answer' => 'Artha adalah aplikasi kasir dan manajemen kantin digital yang dirancang untuk mempermudah pencatatan transaksi, pengelolaan stok, dan laporan keuangan harian secara otomatis.'
                    ],
                    [
                        'question' => 'Apakah data saya aman?',
                        'answer' => 'Ya, kami menggunakan enkripsi standar industri untuk melindungi data transaksi dan informasi pribadi Anda. Kami tidak membagikan data Anda ke pihak ketiga.'
                    ],
                ]
            ],
            [
                'category' => 'Fitur & Penggunaan',
                'items' => [
                    [
                        'question' => 'Bagaimana cara mencetak struk?',
                        'answer' => 'Setelah transaksi selesai, tekan tombol "Cetak Struk". Pastikan perangkat Anda sudah terhubung dengan printer bluetooth yang kompatibel.'
                    ],
                    [
                        'question' => 'Bisakah saya mengedit stok secara manual?',
                        'answer' => 'Tentu. Masuk ke menu "Produk", pilih barang yang ingin diubah, lalu tekan icon pensil (Edit). Anda bisa memperbarui jumlah stok di sana.'
                    ],
                    [
                        'question' => 'Metode pembayaran apa saja yang didukung?',
                        'answer' => 'Saat ini Artha mendukung pencatatan pembayaran Tunai dan QRIS. Laporan akan dipisahkan secara otomatis berdasarkan metode pembayaran.'
                    ],
                ]
            ],
            [
                'category' => 'Akun',
                'items' => [
                    [
                        'question' => 'Bagaimana jika saya lupa password?',
                        'answer' => 'Pada halaman Login, tekan "Lupa Password", masukkan email Anda, dan kami akan mengirimkan tautan untuk membuat password baru.'
                    ],
                ]
            ]
        ];

        return view('faq.index', compact('faqs'));
    }
}