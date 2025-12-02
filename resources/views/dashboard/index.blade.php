@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="bg-gray-50 min-h-screen pb-28"> {{-- Padding bawah besar untuk Bottom Nav --}}

    {{-- 1. Header Section (Top Bar) --}}
    <header class="bg-white px-6 pt-8 pb-4 flex justify-between items-center sticky top-0 z-10 shadow-sm">
        <div class="flex items-center gap-3">
            {{-- Avatar --}}
            <div class="w-12 h-12 rounded-full bg-gray-100 p-0.5 border border-gray-200">
                <div
                    class="w-full h-full rounded-full bg-[#37967D] text-white flex items-center justify-center font-bold text-xl">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Selamat Pagi,</p>
                <h1 class="text-lg font-bold text-gray-900 leading-tight">{{ Auth::user()->name ?? 'Owner' }} 👋</h1>
            </div>
        </div>

        {{-- Notifikasi Icon --}}
        <a href="{{ route('notifications.index') }}"
            class="w-10 h-10 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-100 hover:text-[#37967D] transition relative">
            <i class="fa-regular fa-bell"></i>
            <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
        </a>
    </header>

    <div class="px-6 mt-6">

        {{-- 2. Main Card (Income Today) --}}
        <div
            class="bg-gradient-to-br from-[#37967D] to-[#2a7561] rounded-3xl p-6 text-white shadow-xl shadow-green-900/20 relative overflow-hidden">
            {{-- Decoration Circle --}}
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-green-100 text-sm font-medium mb-1">Pemasukan Hari Ini</p>
                        <h2 class="text-3xl font-bold tracking-tight">Rp{{ number_format($stats['income'], 0, ',', '.')
                            }}</h2>
                    </div>
                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                        <i class="fa-solid fa-wallet text-xl"></i>
                    </div>
                </div>

                {{-- Mini Stats Row --}}
                <div class="flex gap-4">
                    <div class="bg-black/10 px-3 py-2 rounded-xl flex items-center gap-2 flex-1">
                        <i class="fa-solid fa-receipt text-xs text-green-200"></i>
                        <div>
                            <p class="text-[10px] text-green-100">Pesanan</p>
                            <p class="text-sm font-bold">{{ $stats['orders'] }}</p>
                        </div>
                    </div>
                    <div class="bg-black/10 px-3 py-2 rounded-xl flex items-center gap-2 flex-1">
                        <i class="fa-solid fa-box text-xs text-green-200"></i>
                        <div>
                            <p class="text-[10px] text-green-100">Terjual</p>
                            <p class="text-sm font-bold">{{ $stats['sold_items'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Quick Actions Grid --}}
        <h3 class="font-bold text-gray-900 mt-8 mb-4 text-sm">Menu Cepat</h3>
        <div class="grid grid-cols-4 gap-4 text-center">

            {{-- Item 1: Buat Pesanan (Kasir) --}}
            <a href="{{ route('orders.create') }}" class="group">
                <div
                    class="w-14 h-14 mx-auto bg-green-50 rounded-2xl flex items-center justify-center text-[#37967D] text-xl mb-2 group-hover:bg-[#37967D] group-hover:text-white transition shadow-sm">
                    <i class="fa-solid fa-cash-register"></i>
                </div>
                <span class="text-xs font-medium text-gray-600">Kasir</span>
            </a>

            {{-- Item 2: Daftar Menu --}}
            <a href="{{ route('products.index') }}" class="group">
                <div
                    class="w-14 h-14 mx-auto bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 text-xl mb-2 group-hover:bg-orange-500 group-hover:text-white transition shadow-sm">
                    <i class="fa-solid fa-burger"></i>
                </div>
                <span class="text-xs font-medium text-gray-600">Menu</span>
            </a>

            {{-- Item 3: Laporan --}}
            <a href="{{ route('reports.index') }}" class="group">
                <div
                    class="w-14 h-14 mx-auto bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500 text-xl mb-2 group-hover:bg-blue-500 group-hover:text-white transition shadow-sm">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <span class="text-xs font-medium text-gray-600">Laporan</span>
            </a>

            {{-- Item 4: Stok (Link ke Produk juga sementara) --}}
            <a href="{{ route('products.index') }}" class="group">
                <div
                    class="w-14 h-14 mx-auto bg-purple-50 rounded-2xl flex items-center justify-center text-purple-500 text-xl mb-2 group-hover:bg-purple-500 group-hover:text-white transition shadow-sm">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <span class="text-xs font-medium text-gray-600">Stok</span>
            </a>
        </div>

        {{-- 4. Toko Status Banner --}}
        <div class="mt-8 bg-white border border-gray-100 p-4 rounded-2xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-[#37967D]">
                    <i class="fa-solid fa-store"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">Status Toko</h4>
                    <p class="text-xs text-green-600 font-medium">Buka • Menerima Pesanan</p>
                </div>
            </div>
            {{-- Toggle Switch Visual --}}
            <div class="w-12 h-6 bg-[#37967D] rounded-full relative cursor-pointer">
                <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
            </div>
        </div>

        {{-- 5. Recent Transactions --}}
        <div class="flex justify-between items-end mt-8 mb-4">
            <h3 class="font-bold text-gray-900 text-sm">Transaksi Terkini</h3>
            <a href="{{ route('orders.index') }}" class="text-xs text-[#37967D] font-medium hover:underline">Lihat
                Semua</a>
        </div>

        <div class="flex flex-col gap-3">
            @foreach($recentOrders as $order)
            <div class="bg-white p-4 rounded-2xl border border-gray-50 flex justify-between items-center shadow-sm">
                <div class="flex items-center gap-4">
                    {{-- Icon Status --}}
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center 
                        {{ $order['status'] == 'success' ? 'bg-green-50 text-[#37967D]' : 'bg-orange-50 text-orange-500' }}">
                        <i class="fa-solid {{ $order['status'] == 'success' ? 'fa-check' : 'fa-clock' }}"></i>
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">{{ $order['customer'] }}</h4>
                        <p class="text-xs text-gray-400">
                            {{ $order['code'] }} • {{ $order['time']->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <span class="font-bold text-sm text-gray-900">
                    Rp{{ number_format($order['total'], 0, ',', '.') }}
                </span>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection