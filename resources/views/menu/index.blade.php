@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<header class="top-bar">
    <h2>Menu</h2>
</header>

{{-- Search --}}
<form action="{{ route('menu.index') }}" method="GET" class="search-container">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Menu...">
    <button type="submit" class="filter-btn">
        <i class="fa-solid fa-sliders"></i>
    </button>
</form>

{{-- Add Button --}}
<a href="{{ route('menu.create') }}" class="add-product">+ Tambah Produk</a>

{{-- Category Filter (opsional, belum dynamic) --}}
<div class="category">
    <button class="active"><i class="fa-solid fa-hat-chef"></i> Semua</button>
    <button><i class="fa-solid fa-bowl-rice"></i> Nasi</button>
    <button><i class="fa-solid fa-mug-hot"></i> Minuman</button>
    <button><i class="fa-solid fa-utensils"></i> Mie</button>
    <button><i class="fa-solid fa-cookie-bite"></i> Jajan</button>
</div>

{{-- Product List --}}
<div class="product-grid">

    @foreach($products as $product)
        <div class="card">
            {{-- Gambar produk --}}
            @if($product->image)
                <img src="{{ asset('storage/products/' . $product->image) }}" alt="Produk">
            @else
                <img src="https://via.placeholder.com/150" alt="No Image">
            @endif

            {{-- Nama Produk --}}
            <h4>{{ $product->name }}</h4>
            <p class="desc">{{ $product->description }}</p>
            <p class="stock">Stok: {{ $product->stock ?? 0 }}</p>

            <div class="bottom">
                <span class="price">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                </span>

                <div class="actions">
                    <a href="{{ route('menu.edit', $product->id) }}" class="detail-btn">Edit</a>

                    <form action="{{ route('menu.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p style="text-align:center; width:100%; margin-top:20px;">Tidak ada produk ditemukan</p>
    @endforelse

</div>

@endsection
