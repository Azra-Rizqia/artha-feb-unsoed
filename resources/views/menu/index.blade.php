@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<div class="sticky top-0 bg-white z-20 shadow-[0_4px_20px_rgba(0,0,0,0.02)] rounded-b-3xl">
    
    <div class="px-6 pt-8 pb-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-5 tracking-tight">Menu</h2>
        
        <form action="{{ route('menu.index') }}" method="GET" class="flex gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="ph ph-magnifying-glass text-gray-400 text-xl"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full bg-gray-50 border border-gray-100 text-gray-700 text-sm rounded-2xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] transition-all placeholder-gray-400" 
                    placeholder="Cari menu favoritmu...">
            </div>
            <button type="submit" class="bg-white border border-gray-200 text-gray-600 rounded-2xl w-[52px] flex items-center justify-center hover:bg-gray-50 transition-colors shadow-sm">
                <i class="ph ph-sliders-horizontal text-xl"></i>
            </button>
        </form>
    </div>

    <div class="px-6 mb-2">
        <a href="{{ route('menu.create') }}" 
           class="flex items-center justify-center gap-2 w-full bg-[#37967D] text-white font-semibold text-[15px] py-3.5 rounded-2xl shadow-[0_8px_20px_rgba(55,150,125,0.25)] active:scale-98 transition-all hover:bg-[#2f826c]">
           <i class="ph ph-plus-circle text-xl"></i>
           Tambah Produk
        </a>
    </div>

    <div class="pl-6 pb-6 pt-2">
        <div class="flex gap-3 overflow-x-auto pr-6 pb-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
            
            {{-- Helper function untuk class --}}
            @php
                function getCategoryClasses($isActive) {
                    return $isActive 
                        ? 'bg-[#37967D]/[0.08] border-[#37967D] shadow-sm' // Aktif: BG Hijau Pudar
                        : 'bg-white border-gray-100 hover:border-gray-200'; // Tidak Aktif
                }

                function getIconWrapperClasses($isActive) {
                    return $isActive
                        ? 'bg-[#37967D]/20 text-[#37967D]' // Icon Aktif: Lingkaran Hijau Lebih Gelap dikit
                        : 'bg-gray-50 text-gray-400'; // Icon Tidak Aktif
                }

                function getTextClasses($isActive) {
                    return $isActive ? 'text-[#37967D] font-bold' : 'text-gray-500 font-medium';
                }
            @endphp

            {{-- 1. Tombol Semua --}}
            @php $active = !request('search'); @endphp
            <a href="{{ route('menu.index') }}">
                <div class="{{ getCategoryClasses($active) }} w-[88px] h-[92px] border rounded-2xl flex flex-col items-center justify-center gap-2 transition-all duration-300">
                    <div class="{{ getIconWrapperClasses($active) }} w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                        <i class="ph ph-chef-hat text-2xl"></i>
                    </div>
                    <span class="{{ getTextClasses($active) }} text-[12px]">Semua</span>
                </div>
            </a>

            {{-- 2. Tombol Nasi --}}
            @php $active = request('search') == 'Nasi'; @endphp
            <a href="{{ route('menu.index', ['search' => 'Nasi']) }}">
                <div class="{{ getCategoryClasses($active) }} w-[88px] h-[92px] border rounded-2xl flex flex-col items-center justify-center gap-2 transition-all duration-300">
                    <div class="{{ getIconWrapperClasses($active) }} w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                        <i class="ph ph-bowl-food text-2xl"></i>
                    </div>
                    <span class="{{ getTextClasses($active) }} text-[12px]">Nasi</span>
                </div>
            </a>

            {{-- 3. Tombol Minuman --}}
            @php $active = request('search') == 'Minuman'; @endphp
            <a href="{{ route('menu.index', ['search' => 'Minuman']) }}">
                <div class="{{ getCategoryClasses($active) }} w-[88px] h-[92px] border rounded-2xl flex flex-col items-center justify-center gap-2 transition-all duration-300">
                    <div class="{{ getIconWrapperClasses($active) }} w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                        <i class="ph ph-coffee text-2xl"></i> {{-- Coffee lebih mirip cup --}}
                    </div>
                    <span class="{{ getTextClasses($active) }} text-[12px]">Minuman</span>
                </div>
            </a>

            {{-- 4. Tombol Mie --}}
            @php $active = request('search') == 'Mie'; @endphp
            <a href="{{ route('menu.index', ['search' => 'Mie']) }}">
                <div class="{{ getCategoryClasses($active) }} w-[88px] h-[92px] border rounded-2xl flex flex-col items-center justify-center gap-2 transition-all duration-300">
                    <div class="{{ getIconWrapperClasses($active) }} w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                        <i class="ph ph-bowl-steam text-2xl"></i>
                    </div>
                    <span class="{{ getTextClasses($active) }} text-[12px]">Mie</span>
                </div>
            </a>

            {{-- 5. Tombol Jajanan --}}
            @php $active = request('search') == 'Jajanan'; @endphp
            <a href="{{ route('menu.index', ['search' => 'Jajanan']) }}">
                <div class="{{ getCategoryClasses($active) }} w-[88px] h-[92px] border rounded-2xl flex flex-col items-center justify-center gap-2 transition-all duration-300">
                    <div class="{{ getIconWrapperClasses($active) }} w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                        <i class="ph ph-cookie text-2xl"></i>
                    </div>
                    <span class="{{ getTextClasses($active) }} text-[12px]">Jajanan</span>
                </div>
            </a>

            {{-- 6. Tombol Lainnya --}}
            @php $active = request('search') == 'Lainnya'; @endphp
            <a href="{{ route('menu.index', ['search' => 'Lainnya']) }}">
                <div class="{{ getCategoryClasses($active) }} w-[88px] h-[92px] border rounded-2xl flex flex-col items-center justify-center gap-2 transition-all duration-300">
                    <div class="{{ getIconWrapperClasses($active) }} w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                        <i class="ph ph-dots-three text-2xl"></i>
                    </div>
                    <span class="{{ getTextClasses($active) }} text-[12px]">Lainnya</span>
                </div>
            </a>

        </div>
    </div>
</div>

<div class="px-6 pt-4 pb-32">
    <div class="grid grid-cols-2 gap-4">
        @forelse($products as $product)
            <div class="bg-white p-3.5 rounded-2xl shadow-[0_2px_15px_rgba(0,0,0,0.03)] border border-gray-50 flex flex-col justify-between h-full hover:border-[#37967D]/30 transition-colors group">
                <div class="relative w-full aspect-square mb-3 overflow-hidden rounded-xl">
                    @if($product->image_url)
                        <img src="{{ asset('storage/' . $product->image_url) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500" alt="{{ $product->nama_produk }}">
                    @else
                        <div class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-300">
                            <i class="ph ph-image text-3xl"></i>
                        </div>
                    @endif
                </div>

                <div>
                    <h4 class="font-bold text-gray-800 text-[15px] mb-1 line-clamp-1">{{ $product->nama_produk }}</h4>
                    <p class="text-[11px] text-gray-400 leading-snug line-clamp-2 mb-2 h-[2.2em]">{{ $product->deskripsi }}</p>
                    <p class="text-[11px] text-gray-400 mb-3">Stok: <span class="text-gray-600 font-medium">{{ $product->stock }}</span></p>
                </div>

                <div class="flex items-center justify-between mt-auto pt-2 border-t border-dashed border-gray-100">
                    <span class="font-bold text-sm text-gray-800">Rp{{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                    
                    <div class="flex gap-1.5">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('menu.edit', $product->id) }}" 
                           class="bg-[#EBF8F5] text-[#37967D] border border-[#37967D]/20 text-[10px] px-3 py-1.5 rounded-lg font-semibold hover:bg-[#37967D] hover:text-white transition-colors">
                            Edit
                        </a>
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('menu.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-50 text-red-500 border border-red-100 text-[10px] w-8 h-[27px] rounded-lg flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors">
                                <i class="ph ph-trash text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-12">
                <div class="bg-gray-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                    <i class="ph ph-bowl-food text-gray-300 text-4xl"></i>
                </div>
                <h3 class="text-gray-800 font-semibold mb-1">Belum ada produk</h3>
                <p class="text-gray-400 text-sm">Silakan tambah produk baru.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection