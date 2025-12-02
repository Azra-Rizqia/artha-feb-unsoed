@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')

<div class="sticky top-0 bg-[#F7F7F7] z-20 px-6 pt-8 pb-4 flex items-center justify-between">
    <a href="{{ route('orders.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-600 shadow-sm hover:text-[#37967D] transition-all">
        <i class="ph-bold ph-caret-left text-xl"></i>
    </a>
    <h1 class="text-lg font-bold text-gray-900">Struk Pesanan</h1>
    <div class="w-10"></div>
</div>

<div class="px-6 pb-40">
    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden relative">
        
        <div class="absolute -left-3 top-32 w-6 h-6 bg-[#F7F7F7] rounded-full"></div>
        <div class="absolute -right-3 top-32 w-6 h-6 bg-[#F7F7F7] rounded-full"></div>

        <div class="p-8 text-center bg-white">
            <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4 ring-8 ring-green-50/50">
                <i class="ph-fill ph-check-circle text-4xl text-[#37967D]"></i>
            </div>
            <h2 class="text-[#37967D] font-bold text-xl mb-1">Pembayaran Berhasil!</h2>
            <p class="text-xs text-gray-400 font-medium">{{ $order->created_at->translatedFormat('l, d F Y • H:i') }}</p>
        </div>

        <div class="px-6 pb-6 border-b-2 border-dashed border-gray-100">
            @if($order->tipe_pesanan == 'makan_ditempat')
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 shadow-sm">
                        <i class="ph-fill ph-chair text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Tipe Pesanan</p>
                        <p class="text-base font-bold text-gray-800">Makan Ditempat</p>
                    </div>
                </div>
            @else
                <div class="bg-orange-50 border border-orange-100 rounded-2xl p-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-orange-600 shadow-sm">
                        <i class="ph-fill ph-package text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Tipe Pesanan</p>
                        <p class="text-base font-bold text-gray-800">Dibungkus (Take Away)</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <span class="text-sm text-gray-500">Kode Order</span>
                <span class="text-sm font-bold text-gray-900 tracking-wider bg-gray-100 px-2 py-1 rounded">{{ $order->order_code }}</span>
            </div>

            <div class="flex justify-between items-center mb-6">
                <span class="text-sm text-gray-500">Nama Pemesan</span>
                <span class="text-sm font-bold text-gray-900">{{ $order->nama_pemesan }}</span>
            </div>

            <div class="space-y-4 mb-6">
                <p class="text-xs font-bold text-gray-300 uppercase tracking-widest">Rincian Menu</p>
                
                @foreach($order->items as $item)
                <div class="flex justify-between items-start">
                    <div class="flex gap-3">
                        <span class="text-sm font-bold text-[#37967D] bg-[#37967D]/10 w-6 h-6 rounded flex items-center justify-center">{{ $item->jumlah }}x</span>
                        
                        <div>
                            <p class="text-sm font-bold text-gray-800 leading-tight">{{ $item->product->nama_produk }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">@ Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-gray-700">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>

            <div class="border-t-2 border-dashed border-gray-100 my-4"></div>

            <div class="flex justify-between items-center mb-2">
                <span class="text-sm text-gray-500">Metode Pembayaran</span>
                <div class="flex items-center gap-2">
                    @if($order->payment_method == 'tunai')
                        <i class="ph-fill ph-money text-green-500 text-lg"></i>
                        <span class="text-sm font-bold text-gray-800 capitalize">Tunai</span>
                    @else
                        <i class="ph-fill ph-qr-code text-blue-500 text-lg"></i>
                        <span class="text-sm font-bold text-gray-800 capitalize">QRIS</span>
                    @endif
                </div>
            </div>

            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                <span class="text-base font-bold text-gray-800">Total Bayar</span>
                <span class="text-2xl font-bold text-[#37967D]">Rp{{ number_format($order->total_uang_masuk, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 p-5 z-30 max-w-[480px] mx-auto left-0 right-0 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
    <div class="flex gap-3">
        <button onclick="window.print()" class="flex-1 bg-gray-100 text-gray-700 font-bold py-3.5 rounded-2xl flex items-center justify-center gap-2 active:scale-95 transition-transform hover:bg-gray-200">
            <i class="ph-bold ph-printer text-xl"></i>
            <span>Cetak</span>
        </button>

        <a href="{{ route('orders.create') }}" class="flex-[2] bg-[#37967D] text-white font-bold py-3.5 rounded-2xl flex items-center justify-center gap-2 active:scale-95 transition-transform shadow-lg shadow-[#37967D]/25 hover:bg-[#2f826c]">
            <span>Pesanan Baru</span>
            <i class="ph-bold ph-plus-circle text-xl"></i>
        </a>
    </div>
</div>

<style>
    /* Sembunyikan elemen navigasi saat print */
    @media print {
        body * {
            visibility: hidden;
        }
        .bg-white.rounded-\[24px\] {
            visibility: visible;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
        }
        .fixed.bottom-0, .sticky.top-0 {
            display: none;
        }
    }
</style>

@endsection