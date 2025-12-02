@extends('layouts.app')

@section('title', 'Buat Pesanan')

@section('content')

<div class="sticky top-0 bg-white z-20 shadow-[0_4px_20px_rgba(0,0,0,0.02)] rounded-b-3xl">
    <div class="px-6 pt-8 pb-2">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 tracking-tight">Pemesanan</h2>
        
        <div class="flex bg-gray-100 p-1.5 rounded-2xl mb-5">
            <div class="flex-1 text-center py-2.5 rounded-xl text-sm font-bold bg-[#37967D] text-white shadow-sm transition-all cursor-default flex items-center justify-center gap-2">
                <i class="ph ph-plus-circle text-lg"></i> Pesanan Baru
            </div>
            <a href="{{ route('orders.index') }}" class="flex-1 text-center py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:text-gray-700 hover:bg-white/50 transition-all flex items-center justify-center gap-2">
                <i class="ph ph-clock-counter-clockwise text-lg"></i> Riwayat
            </a>
        </div>

        <form method="GET" class="relative mb-2">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="ph ph-magnifying-glass text-gray-400 text-xl"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" 
                class="w-full bg-gray-50 border border-gray-100 text-gray-700 text-sm rounded-2xl pl-11 pr-4 py-3.5 focus:outline-none focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] transition-all placeholder-gray-400" 
                placeholder="Cari menu...">
            <button class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-[#37967D] transition-colors">
                <i class="ph ph-sliders-horizontal text-xl"></i>
            </button>
        </form>
    </div>

    <div class="pl-6 pb-6 pt-1">
        <div class="flex gap-3 overflow-x-auto pr-6 pb-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:'none'] [scrollbar-width:'none']">
            @php 
                $categories = [
                    ['label' => 'Semua', 'icon' => 'ph-chef-hat'],
                    ['label' => 'Nasi', 'icon' => 'ph-bowl-food'],
                    ['label' => 'Minuman', 'icon' => 'ph-coffee'],
                    ['label' => 'Mie', 'icon' => 'ph-bowl-steam'],
                    ['label' => 'Jajanan', 'icon' => 'ph-cookie']
                ];
                $currentCat = request('category');
            @endphp

            @foreach($categories as $cat)
                @php 
                    $isActive = ($currentCat == $cat['label'] || (!$currentCat && $cat['label'] == 'Semua'));
                    $boxClass = $isActive ? 'bg-[#37967D]/[0.08] border-[#37967D] shadow-sm' : 'bg-white border-gray-100 hover:border-gray-200';
                    $iconClass = $isActive ? 'bg-[#37967D]/20 text-[#37967D]' : 'bg-gray-50 text-gray-400';
                    $textClass = $isActive ? 'text-[#37967D] font-bold' : 'text-gray-500 font-medium';
                @endphp

                <a href="{{ route('orders.create', ['category' => $cat['label'] == 'Semua' ? null : $cat['label']]) }}">
                    <div class="{{ $boxClass }} w-[88px] h-[92px] border rounded-2xl flex flex-col items-center justify-center gap-2 transition-all duration-300">
                        <div class="{{ $iconClass }} w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                            <i class="ph {{ $cat['icon'] }} text-2xl"></i>
                        </div>
                        <span class="{{ $textClass }} text-[12px]">{{ $cat['label'] }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="px-6 pt-4 pb-48">
    <div class="grid grid-cols-2 gap-4">
        @forelse($products as $product)
        <div class="bg-white p-3.5 rounded-2xl shadow-[0_2px_15px_rgba(0,0,0,0.03)] border border-gray-50 flex flex-col h-full group transition-all hover:border-[#37967D]/30 product-card"
             data-id="{{ $product->id }}">
            
            <div class="relative w-full aspect-square mb-3 overflow-hidden rounded-xl bg-gray-50">
                @if($product->image_url)
                    <img src="{{ asset('storage/' . $product->image_url) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <i class="ph ph-image text-3xl"></i>
                    </div>
                @endif
            </div>

            <h4 class="font-bold text-gray-900 text-[15px] leading-tight mb-1 line-clamp-1">{{ $product->nama_produk }}</h4>
            <p class="text-[11px] text-gray-400 leading-snug line-clamp-2 mb-2 h-[2.2em]">{{ $product->deskripsi }}</p>
            <p class="text-[11px] text-gray-400 mb-3">Stok: <span class="font-medium text-gray-600">{{ $product->stock }}</span></p>
            
            <div class="flex items-center justify-between mt-auto pt-2 border-t border-dashed border-gray-100">
                <span class="font-bold text-sm text-gray-900">Rp{{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                <div class="flex items-center gap-2">
                    <button type="button" class="btn-minus hidden w-8 h-8 rounded-xl border border-gray-200 flex items-center justify-center text-gray-500 active:bg-gray-100 hover:border-[#37967D] hover:text-[#37967D] transition-all">
                        <i class="ph-bold ph-minus text-xs"></i>
                    </button>
                    <span class="qty-display hidden text-sm font-bold text-gray-800 w-5 text-center">0</span>
                    <button type="button" class="btn-plus w-8 h-8 rounded-xl bg-[#37967D] text-white flex items-center justify-center shadow-lg shadow-[#37967D]/20 active:scale-90 hover:bg-[#2f826c] transition-all">
                        <i class="ph-bold ph-plus text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
            <div class="col-span-2 text-center py-12">
                <div class="bg-gray-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                    <i class="ph ph-bowl-food text-gray-300 text-4xl"></i>
                </div>
                <h3 class="text-gray-800 font-semibold mb-1">Menu tidak ditemukan</h3>
            </div>
        @endforelse
    </div>
</div>

<div id="checkoutBar" class="invisible fixed bottom-24 left-0 w-full px-6 z-40 max-w-[480px] mx-auto left-0 right-0 transform translate-y-10 transition-all duration-300">
    <button type="button" onclick="openCheckoutModal()" class="w-full bg-[#37967D] text-white font-bold py-4 rounded-2xl shadow-2xl shadow-[#37967D]/40 flex justify-between items-center px-6 active:scale-98 transition-transform hover:bg-[#2f826c] border border-white/10 backdrop-blur-sm">
        <div class="flex flex-col items-start">
            <span class="text-[10px] uppercase tracking-wider opacity-80 font-medium">Total Pesanan</span>
            <span id="barTotalPrice" class="text-lg font-bold">Rp0</span>
        </div>
        <div class="flex items-center gap-3 bg-black/10 px-4 py-2 rounded-xl">
            <span class="text-sm font-bold">Proses</span>
            <span id="totalItems" class="bg-white text-[#37967D] px-2 py-0.5 rounded-md text-[10px] font-bold">0</span>
            <i class="ph-bold ph-arrow-right"></i>
        </div>
    </button>
</div>

<div id="checkoutModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeCheckoutModal()"></div>
    
    <div class="absolute bottom-0 w-full max-w-[480px] bg-white rounded-t-[32px] p-6 animate-slide-up shadow-2xl h-[85vh] flex flex-col">
        <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-6 shrink-0"></div>
        
        <div class="flex justify-between items-center mb-6 shrink-0">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Konfirmasi Pesanan</h3>
                <p class="text-xs text-gray-400 mt-1">Periksa kembali pesanan pelanggan</p>
            </div>
            <button type="button" onclick="closeCheckoutModal()" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors">
                <i class="ph-bold ph-x"></i>
            </button>
        </div>
        
        <div class="overflow-y-auto flex-1 -mx-6 px-6 pb-6">
            <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                @csrf
                <input type="hidden" name="cart" id="cartInput">
                
                <div class="mb-6 bg-gray-50 rounded-2xl p-4 border border-gray-100">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Item Dipesan</h4>
                    <div id="cartSummaryList" class="space-y-3"></div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Nama Pemesan</label>
                    <div class="relative">
                        <i class="ph ph-user absolute left-4 top-3.5 text-gray-400 text-lg"></i>
                        <input type="text" name="nama_pemesan" required class="w-full bg-white border border-gray-200 rounded-xl pl-11 pr-4 py-3.5 text-sm font-medium text-gray-800 focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] focus:outline-none transition-all placeholder-gray-400" placeholder="Masukkan nama pelanggan">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Tipe Pesanan</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="tipe_pesanan" value="makan_ditempat" class="peer hidden" checked>
                            <div class="flex items-center justify-center gap-2 py-3.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 peer-checked:border-[#37967D] peer-checked:text-[#37967D] peer-checked:bg-[#37967D]/5 transition-all">
                                <i class="ph-fill ph-chair text-lg"></i> Dine In
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="tipe_pesanan" value="bungkus" class="peer hidden">
                            <div class="flex items-center justify-center gap-2 py-3.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 peer-checked:border-[#37967D] peer-checked:text-[#37967D] peer-checked:bg-[#37967D]/5 transition-all">
                                <i class="ph-fill ph-package text-lg"></i> Take Away
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Metode Pembayaran</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="payment_method" value="tunai" class="peer hidden" checked>
                            <div class="flex items-center justify-center gap-2 py-3.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 peer-checked:border-[#37967D] peer-checked:text-[#37967D] peer-checked:bg-[#37967D]/5 transition-all">
                                <i class="ph-fill ph-money text-lg"></i> Tunai
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="payment_method" value="qris" class="peer hidden">
                            <div class="flex items-center justify-center gap-2 py-3.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 peer-checked:border-[#37967D] peer-checked:text-[#37967D] peer-checked:bg-[#37967D]/5 transition-all">
                                <i class="ph-fill ph-qr-code text-lg"></i> QRIS
                            </div>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <div class="pt-4 border-t border-gray-100 shrink-0">
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm font-medium text-gray-500">Total Pembayaran</span>
                <span class="text-2xl font-bold text-[#37967D]" id="modalTotalPrice">Rp0</span>
            </div>
            <button type="submit" form="orderForm" class="w-full bg-[#37967D] text-white font-bold py-4 rounded-xl shadow-lg shadow-[#37967D]/25 active:scale-95 transition-transform flex justify-center items-center gap-2 hover:bg-[#2f826c]">
                <span>Buat Pesanan</span>
                <i class="ph-bold ph-paper-plane-right"></i>
            </button>
        </div>
    </div>
</div>

<div id="product-data" data-products="{{ json_encode($products->keyBy('id')) }}" class="hidden"></div>

<script>
    // FIX: Ambil data dari atribut HTML, bukan dari sintaks Blade langsung di script
    const productDataElement = document.getElementById('product-data');
    const dbProducts = JSON.parse(productDataElement.getAttribute('data-products'));
    
    let cart = {}; 

    document.addEventListener("DOMContentLoaded", () => {
        const productCards = document.querySelectorAll('.product-card');
        const checkoutBar = document.getElementById('checkoutBar');
        const totalItemsSpan = document.getElementById('totalItems');
        const barTotalPriceSpan = document.getElementById('barTotalPrice');

        productCards.forEach(card => {
            const id = card.dataset.id;
            const btnPlus = card.querySelector('.btn-plus');
            const btnMinus = card.querySelector('.btn-minus');

            btnPlus.addEventListener('click', () => {
                cart[id] = (cart[id] || 0) + 1;
                updateCardUI(card, id);
                updateFloatingBar();
            });

            btnMinus.addEventListener('click', () => {
                if (cart[id] > 0) {
                    cart[id]--;
                    if (cart[id] === 0) delete cart[id];
                }
                updateCardUI(card, id);
                updateFloatingBar();
            });
        });

        function updateCardUI(card, id) {
            const qty = cart[id] || 0;
            const btnMinus = card.querySelector('.btn-minus');
            const qtyDisplay = card.querySelector('.qty-display');
            qtyDisplay.innerText = qty;

            if (qty > 0) {
                btnMinus.classList.remove('hidden');
                qtyDisplay.classList.remove('hidden');
                card.classList.add('border-[#37967D]', 'bg-green-50/30');
            } else {
                btnMinus.classList.add('hidden');
                qtyDisplay.classList.add('hidden');
                card.classList.remove('border-[#37967D]', 'bg-green-50/30');
            }
        }

        function updateFloatingBar() {
            let totalQty = 0;
            let totalPrice = 0;

            for (const [id, qty] of Object.entries(cart)) {
                if(dbProducts[id]) {
                    totalQty += qty;
                    totalPrice += dbProducts[id].harga_jual * qty;
                }
            }

            totalItemsSpan.innerText = totalQty;
            const formattedPrice = 'Rp' + totalPrice.toLocaleString('id-ID');
            barTotalPriceSpan.innerText = formattedPrice;
            document.getElementById('modalTotalPrice').innerText = formattedPrice;

            if (totalQty > 0) {
                checkoutBar.classList.remove('invisible', 'translate-y-10');
            } else {
                checkoutBar.classList.add('invisible', 'translate-y-10');
            }
        }
    });

    function openCheckoutModal() {
        const cartData = [];
        const summaryList = document.getElementById('cartSummaryList');
        summaryList.innerHTML = ''; 

        for (const [id, qty] of Object.entries(cart)) {
            const product = dbProducts[id];
            if (product) {
                cartData.push({ id: id, qty: qty });
                const subtotal = product.harga_jual * qty;

                const html = `
                    <div class="flex justify-between items-center text-sm border-b border-gray-100 pb-2 last:border-0">
                        <div>
                            <span class="font-medium text-gray-700">${product.nama_produk}</span>
                            <div class="text-xs text-gray-400 mt-0.5">${qty} x Rp${product.harga_jual.toLocaleString('id-ID')}</div>
                        </div>
                        <span class="font-bold text-gray-900">Rp${subtotal.toLocaleString('id-ID')}</span>
                    </div>
                `;
                summaryList.innerHTML += html;
            }
        }
        document.getElementById('cartInput').value = JSON.stringify(cartData);
        document.getElementById('checkoutModal').classList.remove('hidden');
    }

    function closeCheckoutModal() {
        document.getElementById('checkoutModal').classList.add('hidden');
    }
</script>

<style>
    @keyframes slide-up {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-up {
        animation: slide-up 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

@endsection