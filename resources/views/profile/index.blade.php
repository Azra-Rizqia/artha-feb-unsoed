@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="bg-white min-h-screen pb-24"> {{-- Padding bawah agar tidak tertutup bottom nav --}}

    {{-- Header --}}
    <header class="px-6 pt-8 pb-4">
        <h3 class="text-2xl font-bold text-gray-900">Profile</h3>
    </header>

    {{-- User Info Section --}}
    <div class="flex flex-col items-center mt-4 mb-8">
        {{-- Avatar Circle --}}
        <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center text-[#37967D] text-4xl mb-4">
            {{-- Mengambil inisial nama depan --}}
            <span class="font-bold">{{ substr($user->name ?? 'U', 0, 1) }}</span>
        </div>

        {{-- Name & Email --}}
        <h2 class="text-xl font-bold text-gray-900">{{ $user->name ?? 'Nama Pengguna' }}</h2>
        <p class="text-sm text-gray-500">{{ $user->email ?? 'email@contoh.com' }}</p>

        {{-- Edit Button --}}
        <button
            class="mt-4 bg-[#37967D] text-white px-6 py-1.5 rounded-full text-xs font-bold tracking-wide hover:bg-[#2a7561] transition">
            Edit Profile
        </button>
    </div>

    {{-- Menu List Helper Component --}}
    @php
    // Fungsi kecil untuk render item menu agar kodenya rapi
    function renderMenuItem($icon, $label, $link = '#') {
    return '
    <a href="'.$link.'"
        class="flex items-center justify-between px-6 py-4 border-b border-gray-50 hover:bg-gray-50 transition group">
        <div class="flex items-center gap-4">
            <div class="text-gray-800 w-6 text-center group-hover:text-[#37967D] transition">
                <i class="fa-solid '.$icon.' text-lg"></i>
            </div>
            <span class="text-gray-900 font-medium text-[15px]">'.$label.'</span>
        </div>
        <i class="fa-solid fa-chevron-right text-gray-300 text-sm"></i>
    </a>
    ';
    }
    @endphp

    {{-- Section: Pengaturan Umum --}}
    <div class="mt-2">
        <h3 class="px-6 text-sm font-medium text-gray-400 mb-2">Pengaturan Umum</h3>
        <div class="bg-white flex flex-col">
            {!! renderMenuItem('fa-shop', 'Data Kantin') !!}
            {!! renderMenuItem('fa-bell', 'Notifikasi') !!}
            {!! renderMenuItem('fa-ellipsis', 'Ganti Password') !!}
            {!! renderMenuItem('fa-gear', 'Pengaturan') !!}
        </div>
    </div>

    {{-- Section: Bantuan --}}
    <div class="mt-8">
        <h3 class="px-6 text-sm font-medium text-gray-400 mb-2">Bantuan</h3>
        <div class="bg-white flex flex-col">
            {!! renderMenuItem('fa-circle-user', 'QnA') !!}
            {!! renderMenuItem('fa-circle-question', 'FAQ') !!}
        </div>
    </div>

    {{-- Tombol Logout (Opsional, biasanya ada di profil) --}}
    <div class="mt-8 px-6">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full py-3 text-red-500 font-medium text-sm bg-red-50 rounded-xl hover:bg-red-100 transition">
                Keluar Aplikasi
            </button>
        </form>
    </div>

</div>
@endsection