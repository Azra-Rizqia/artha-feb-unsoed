<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class QnaController extends Controller
{
    public function index()
    {
        // Data Dummy Percakapan
        $messages = [
            [
                'id' => 1,
                'sender' => 'admin', // Pengirim: Admin
                'message' => 'Halo! Ada yang bisa kami bantu terkait aplikasi Artha?',
                'created_at' => Carbon::today()->setHour(9)->setMinute(0),
            ],
            [
                'id' => 2,
                'sender' => 'user', // Pengirim: Kita (User)
                'message' => 'Siang min, mau tanya cara ganti foto profil toko gimana ya?',
                'created_at' => Carbon::today()->setHour(9)->setMinute(15),
            ],
            [
                'id' => 3,
                'sender' => 'admin',
                'message' => 'Selamat siang Kak. Untuk mengganti foto profil, Kakak bisa masuk ke menu "Profile" di pojok kanan bawah, lalu klik tombol hijau bertuliskan "Edit Profile".',
                'created_at' => Carbon::today()->setHour(9)->setMinute(20),
            ],
            [
                'id' => 4,
                'sender' => 'user',
                'message' => 'Oh begitu, oke siap terima kasih infonya min!',
                'created_at' => Carbon::now()->subMinutes(5),
            ],
        ];

        return view('qna.index', compact('messages'));
    }
}