@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')

<div class="sticky top-0 bg-white z-20 px-6 pt-8 pb-4 shadow-[0_1px_2px_rgba(0,0,0,0.02)] rounded-b-3xl">
    <h2 class="text-2xl font-bold text-gray-900 mb-5 tracking-tight">Pemesanan</h2>
    
    <form action="{{ route('orders.index') }}" method="GET" class="relative mb-4">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <i class="ph ph-magnifying-glass text-gray-400 text-xl"></i>
        </div>
        <input type="text" name="search" value="{{ request('search') }}" 
            class="w-full bg-gray-50 border border-gray-100 text-gray-700 text-sm rounded-2xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] transition-all placeholder-gray-400" 
            placeholder="Cari ID Pesanan atau Nama...">
    </form>

    <div class="flex bg-gray-100 p-1.5 rounded-2xl">
        {{-- Tab Pesanan Baru (Link ke Create) --}}
        <a href="{{ route('orders.create') }}" class="flex-1 text-center py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:text-gray-700 transition-all">
            Pesanan Baru
        </a>
        
        {{-- Tab Riwayat (Aktif) --}}
        <div class="flex-1 text-center py-2.5 rounded-xl text-sm font-bold bg-white text-[#37967D] shadow-sm ring-1 ring-gray-200 transition-all">
            Riwayat Pesanan
        </div>
    </div>
</div>

<div class="px-6 pt-4 pb-32">
    @forelse($orders as $order)
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] mb-4 hover:border-[#37967D]/30 transition-all">
            <div class="flex justify-between items-start mb-3 pb-3 border-b border-dashed border-gray-100">
                <div>
                    <h4 class="font-bold text-gray-800 text-sm">{{ $order->order_code }}</h4>
                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-[10px] font-bold 
                    {{ $order->status == 'selesai' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="flex justify-between items-center mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                        <i class="ph-fill ph-user"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400">Pemesan</span>
                        <span class="text-xs font-semibold text-gray-700">{{ $order->nama_pemesan }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-gray-400 block">Total Bayar</span>
                    <span class="text-sm font-bold text-[#37967D]">Rp{{ number_format($order->total_uang_masuk, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex items-center gap-1.5 text-[11px] text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">
                    <i class="ph-fill ph-shopping-bag"></i> {{ $order->items_count }} Item
                </div>
                
                <div class="flex items-center gap-1.5 text-[11px] text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">
                    @if($order->payment_method == 'tunai')
                        <i class="ph-fill ph-money"></i> Tunai
                    @else
                        <i class="ph-fill ph-qr-code"></i> QRIS
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <div class="bg-gray-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                <i class="ph ph-receipt text-gray-300 text-4xl"></i>
            </div>
            <h3 class="text-gray-800 font-semibold mb-1">Belum ada riwayat</h3>
            <p class="text-gray-400 text-sm">Pesanan yang selesai akan muncul disini.</p>
        </div>
    @endforelse
</div>

@endsection