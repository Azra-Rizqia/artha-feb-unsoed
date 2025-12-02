@extends('layouts.app')

@section('title', 'Buat Pesanan')

@section('content')

<div class="sticky top-0 bg-white z-20 shadow-[0_4px_20px_rgba(0,0,0,0.02)] rounded-b-3xl">
    <div class="px-6 pt-8 pb-2">
        <h2 class="text-2xl font-bold text-gray-900 mb-5 tracking-tight">Pemesanan</h2>
        
        <form method="GET" class="relative mb-4">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="ph ph-magnifying-glass text-gray-400 text-xl"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" 
                class="w-full bg-gray-50 border border-gray-100 text-gray-700 text-sm rounded-2xl pl-11 pr-12 py-3.5 focus:outline-none focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] transition-all placeholder-gray-400" 
                placeholder="Cari menu...">
            <button class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500">
                <i class="ph ph-sliders-horizontal text-xl"></i>
            </button>
        </form>

        <div class="flex bg-gray-100 p-1.5 rounded-2xl mb-4">
            {{-- Tab Pesanan Baru (Aktif) --}}
            <div class="flex-1 text-center py-2.5 rounded-xl text-sm font-bold bg-[#37967D] text-white shadow-sm transition-all cursor-default">
                Pesanan Baru
            </div>
            
            {{-- Tab Riwayat --}}
            <a href="{{ route('orders.index') }}" class="flex-1 text-center py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:text-gray-700 transition-all">
                Riwayat Pesanan
            </a>
        </div>
    </div>

    <div class="pl-6 pb-4 pt-1 overflow-x-auto [&::-webkit-scrollbar]:hidden">
        <div class="flex gap-3 pr-6">
            @php 
                $categories = [
                    ['label' => 'Semua', 'icon' => 'ph-squares-four'],
                    ['label' => 'Nasi', 'icon' => 'ph-bowl-food'],
                    ['label' => 'Minuman', 'icon' => 'ph-coffee'],
                    ['label' => 'Mie', 'icon' => 'ph-bowl-steam'],
                    ['label' => 'Jajanan', 'icon' => 'ph-cookie']
                ];
                $currentCat = request('category');
            @endphp

            @foreach($categories as $cat)
                <a href="{{ route('orders.create', ['category' => $cat['label'] == 'Semua' ? null : $cat['label']]) }}" 
                   class="{{ ($currentCat == $cat['label'] || (!$currentCat && $cat['label'] == 'Semua')) 
                       ? 'bg-[#37967D]/10 text-[#37967D] border-[#37967D]' 
                       : 'bg-white text-gray-500 border-gray-100' }} 
                       border px-4 py-2.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors flex items-center gap-2">
                   <i class="ph-fill {{ $cat['icon'] }} text-lg"></i>
                   {{ $cat['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="px-6 pt-4 pb-40">
    <div class="grid grid-cols-2 gap-4">
        @forelse($products as $product)
        <div class="bg-white p-3 rounded-2xl shadow-[0_2px_15px_rgba(0,0,0,0.03)] border border-gray-50 flex flex-col h-full group transition-all hover:border-[#37967D]/30"
             data-id="{{ $product->id }}" 
             data-name="{{ $product->nama_produk }}"
             data-price="{{ $product->harga_jual }}">
            
            <div class="flex justify-center mb-3">
                <div class="relative w-28 h-28 rounded-full overflow-hidden shadow-md border-2 border-white">
                    @if($product->image_url)
                        <img src="{{ asset('storage/' . $product->image_url) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300">
                            <i class="ph ph-image text-3xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            <h4 class="font-bold text-gray-900 text-[14px] leading-tight mb-1 line-clamp-1">{{ $product->nama_produk }}</h4>
            <p class="text-[11px] text-gray-400 leading-snug line-clamp-2 mb-1 h-[2.4em]">{{ $product->deskripsi }}</p>
            <p class="text-[11px] text-gray-400 mb-3">Stok: <span class="font-medium text-gray-600">{{ $product->stock }}</span></p>
            
            <div class="flex items-center justify-between mt-auto">
                <span class="font-bold text-[13px] text-gray-900">Rp{{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                
                <div class="flex items-center gap-2">
                    <button class="btn-minus hidden w-7 h-7 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 active:bg-gray-100 transition-colors">
                        <i class="ph-bold ph-minus text-xs"></i>
                    </button>
                    
                    <span class="qty-display hidden text-sm font-bold text-gray-800 w-4 text-center">0</span>

                    <button class="btn-plus w-7 h-7 rounded-full bg-[#1B1B1B] text-white flex items-center justify-center shadow-md active:scale-90 transition-transform">
                        <i class="ph-bold ph-plus text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
            <div class="col-span-2 text-center py-12">
                <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                    <i class="ph ph-bowl-food text-gray-300 text-3xl"></i>
                </div>
                <p class="text-gray-400 text-sm">Tidak ada menu tersedia.</p>
            </div>
        @endforelse
    </div>
</div>

<div id="checkoutBar" class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 p-5 z-40 max-w-[480px] mx-auto left-0 right-0 transform translate-y-full transition-transform duration-300 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
    <button onclick="openCheckoutModal()" class="w-full bg-[#37967D] text-white font-bold py-4 rounded-2xl shadow-lg shadow-[#37967D]/20 flex justify-between items-center px-6 active:scale-98 transition-transform">
        <span class="text-sm">Proses Pesanan Baru</span>
        <div class="flex items-center gap-2">
            <span id="totalItems" class="bg-white/20 px-2.5 py-1 rounded-lg text-xs font-semibold">0 produk</span>
            <i class="ph-bold ph-arrow-right"></i>
        </div>
    </button>
</div>

<div id="checkoutModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="closeCheckoutModal()"></div>
    
    <div class="absolute bottom-0 w-full max-w-[480px] bg-white rounded-t-[32px] p-6 animate-slide-up shadow-2xl">
        <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-8"></div>
        
        <h3 class="text-xl font-bold text-gray-900 mb-6">Konfirmasi Pesanan</h3>
        
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <input type="hidden" name="cart" id="cartInput">
            <div class="mb-5">
                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Nama Pemesan</label>
                <input type="text" name="nama_pemesan" required 
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-medium text-gray-800 focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] focus:outline-none transition-all placeholder-gray-400"
                    placeholder="Masukkan nama pelanggan">
            </div>

            <div class="mb-5">
                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Tipe Pesanan</label>
                <div class="flex gap-3">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="tipe_pesanan" value="makan_ditempat" class="peer hidden" checked>
                        <div class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 peer-checked:border-[#37967D] peer-checked:text-[#37967D] peer-checked:bg-[#37967D]/5 transition-all">
                            <i class="ph-fill ph-chair"></i> Makan Ditempat
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="tipe_pesanan" value="bungkus" class="peer hidden">
                        <div class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 peer-checked:border-[#37967D] peer-checked:text-[#37967D] peer-checked:bg-[#37967D]/5 transition-all">
                            <i class="ph-fill ph-package"></i> Bungkus
                        </div>
                    </label>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Metode Pembayaran</label>
                <div class="flex gap-3">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="payment_method" value="tunai" class="peer hidden" checked>
                        <div class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 peer-checked:border-[#37967D] peer-checked:text-[#37967D] peer-checked:bg-[#37967D]/5 transition-all">
                            <i class="ph-fill ph-money"></i> Tunai
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="payment_method" value="qris" class="peer hidden">
                        <div class="flex items-center justify-center gap-2 py-3 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 peer-checked:border-[#37967D] peer-checked:text-[#37967D] peer-checked:bg-[#37967D]/5 transition-all">
                            <i class="ph-fill ph-qr-code"></i> QRIS
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex justify-between items-center mb-6 pt-4 border-t border-dashed border-gray-200">
                <span class="text-sm font-medium text-gray-500">Total Pembayaran</span>
                <span class="text-xl font-bold text-[#37967D]" id="modalTotalPrice">Rp0</span>
            </div>

            <button type="submit" class="w-full bg-[#37967D] text-white font-bold py-4 rounded-xl shadow-lg shadow-[#37967D]/20 active:scale-95 transition-transform flex justify-center items-center gap-2">
                <span>Buat Pesanan</span>
                <i class="ph-bold ph-arrow-right"></i>
            </button>
        </form>
    </div>
</div>

{{-- Logic Javascript --}}
<script>
    let cart = {}; 

    document.addEventListener("DOMContentLoaded", () => {
        const productCards = document.querySelectorAll('[data-id]');
        const checkoutBar = document.getElementById('checkoutBar');
        const totalItemsSpan = document.getElementById('totalItems');

        productCards.forEach(card => {
            const id = card.dataset.id;
            const price = parseInt(card.dataset.price);
            
            // Elemen tombol
            const btnPlus = card.querySelector('.btn-plus');
            const btnMinus = card.querySelector('.btn-minus');
            const qtyDisplay = card.querySelector('.qty-display');

            // --- TOMBOL PLUS ---
            btnPlus.addEventListener('click', () => {
                cart[id] = (cart[id] || 0) + 1;
                updateCardUI(card, id);
                updateFloatingBar();
            });

            // --- TOMBOL MINUS ---
            btnMinus.addEventListener('click', () => {
                if (cart[id] > 0) {
                    cart[id]--;
                    if (cart[id] === 0) delete cart[id];
                }
                updateCardUI(card, id);
                updateFloatingBar();
            });
        });

        // Update Tampilan Kartu (Munculkan/Sembunyikan Minus)
        function updateCardUI(card, id) {
            const qty = cart[id] || 0;
            const btnMinus = card.querySelector('.btn-minus');
            const qtyDisplay = card.querySelector('.qty-display');

            qtyDisplay.innerText = qty;

            if (qty > 0) {
                btnMinus.classList.remove('hidden');
                qtyDisplay.classList.remove('hidden');
            } else {
                btnMinus.classList.add('hidden');
                qtyDisplay.classList.add('hidden');
            }
        }

        // Update Floating Bar Bawah
        function updateFloatingBar() {
            let totalQty = 0;
            let totalPrice = 0;

            for (const [id, qty] of Object.entries(cart)) {
                totalQty += qty;
                const card = document.querySelector(`[data-id="${id}"]`);
                const price = parseInt(card.dataset.price);
                totalPrice += price * qty;
            }

            totalItemsSpan.innerText = `${totalQty} produk`;
            document.getElementById('modalTotalPrice').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');

            // Slide Up/Down Logic
            if (totalQty > 0) {
                checkoutBar.classList.remove('translate-y-full');
            } else {
                checkoutBar.classList.add('translate-y-full');
            }
        }
    });

    // Modal Functions
    function openCheckoutModal() {
        const cartData = [];
        for (const [id, qty] of Object.entries(cart)) {
            cartData.push({ id: id, qty: qty });
        }
        // Masukkan data JSON ke hidden input
        document.getElementById('cartInput').value = JSON.stringify(cartData);
        
        document.getElementById('checkoutModal').classList.remove('hidden');
    }

    function closeCheckoutModal() {
        document.getElementById('checkoutModal').classList.add('hidden');
    }
</script>

<style>
    /* Animasi Slide Up untuk Modal */
    @keyframes slide-up {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-up {
        animation: slide-up 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

@endsection