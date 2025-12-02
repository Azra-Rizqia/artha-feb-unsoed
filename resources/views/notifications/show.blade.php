@extends('layouts.app')

@section('title', 'Detail Notifikasi')

@section('content')
<div class="bg-white min-h-screen pb-24">

    {{-- Header --}}
    <header
        class="sticky top-0 z-10 bg-white/80 backdrop-blur-md border-b border-gray-100 px-6 py-4 flex items-center gap-4">
        <a href="{{ route('notifications.index') }}"
            class="text-gray-500 hover:text-gray-900 transition p-1 -ml-1 rounded-full hover:bg-gray-100">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-lg font-bold text-gray-900">Detail Pesan</h1>
    </header>

    <div class="px-6 py-6">
        {{-- Tanggal & Status --}}
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-medium text-gray-400 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
                {{ \Carbon\Carbon::parse($notification['created_at'])->translatedFormat('l, d F Y • H:i') }}
            </span>

            {{-- Label Tipe (Opsional) --}}
            @php
            $typeColors = [
            'order' => 'text-blue-600 bg-blue-50',
            'stock' => 'text-red-600 bg-red-50',
            'payment' => 'text-green-600 bg-green-50',
            'system' => 'text-gray-600 bg-gray-50',
            ];
            $colorClass = $typeColors[$notification['type']] ?? 'text-gray-600 bg-gray-50';
            @endphp
            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded {{ $colorClass }}">
                {{ $notification['type'] ?? 'Info' }}
            </span>
        </div>

        {{-- Judul Besar --}}
        <h2 class="text-2xl font-bold text-gray-900 leading-tight mb-6">
            {{ $notification['title'] }}
        </h2>

        {{-- Divider Halus --}}
        <hr class="border-gray-100 mb-6">

        {{-- Isi Konten --}}
        <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
            <p>{{ $notification['body'] }}</p>
        </div>
    </div>

    {{-- Action Button (Opsional, misal jika notifikasi stok habis, arahkan ke stok) --}}
    @if($notification['type'] === 'stock')
    <div class="fixed bottom-20 left-0 w-full px-6">
        <a href="#"
            class="block w-full bg-[#37967D] text-white text-center font-medium py-3.5 rounded-xl shadow-lg shadow-green-900/10 hover:bg-[#2a7561] transition">
            Cek Stok Sekarang
        </a>
    </div>
    @endif

</div>
@endsection