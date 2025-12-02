@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')

<form action="{{ route('orders.store') }}" method="POST" id="confirmForm" class="min-h-screen pb-32">
    @csrf
    
    <input type="hidden" name="cart" id="cartInput">
    <input type="hidden" name="order_code" value="{{ $orderCode }}">

    <div class="sticky top-0 bg-[#F7F7F7] z-30 px-6 pt-8 pb-4 flex items-center justify-between">
        <a href="{{ route('orders.create') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-600 shadow-sm border border-gray-100 hover:text-[#37967D] transition-all">
            <i class="ph-bold ph-caret-left text-xl"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-900">Detail Pesanan</h1>
        <div class="w-10"></div>
    </div>

    <div class="px-6 space-y-5">
        
        <div class="bg-white p-5 rounded-[24px] shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <i class="ph-fill ph-user-circle text-[#37967D] text-xl"></i>
                <h3 class="text-sm font-bold text-gray-900">Data Pelanggan</h3>
            </div>
            
            <div class="mb-5">
                <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-wide">Nama Pemesan</label>
                <input type="text" name="nama_pemesan" required
                    class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3.5 text-sm font-bold text-gray-800 focus:bg-white focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] outline-none transition-all placeholder-gray-400"
                    placeholder="Contoh: Budi">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 mb-2 uppercase tracking-wide">Tipe Pesanan</label>
                <input type="hidden" name="tipe_pesanan" id="orderType" value="makan_ditempat">

                <div class="grid grid-cols-2 gap-3">
                    <button type="button" id="btnMakan" onclick="setOrderType('makan_ditempat')"
                        class="relative flex flex-col items-center justify-center gap-2 py-4 rounded-2xl border-2 transition-all border-[#37967D] bg-[#37967D]/5 text-[#37967D]">
                        <i class="ph-fill ph-chair text-3xl"></i>
                        <span class="text-[11px] font-bold">Dine In</span>
                        <div class="absolute top-2 right-2 text-[#37967D]"><i class="ph-fill ph-check-circle"></i></div>
                    </button>

                    <button type="button" id="btnBungkus" onclick="setOrderType('bungkus')"
                        class="relative flex flex-col items-center justify-center gap-2 py-4 rounded-2xl border-2 transition-all border-gray-100 bg-white text-gray-400">
                        <i class="ph-fill ph-package text-3xl"></i>
                        <span class="text-[11px] font-bold">Take Away</span>
                        <div class="absolute top-2 right-2 text-[#37967D] opacity-0"><i class="ph-fill ph-check-circle"></i></div>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[24px] shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgMTBMMTAgMCAyMCAxMHoiIGZpbGw9IiNmN2Y3ZjciLz48L3N2Zz4=')] opacity-60"></div>
            
            <div class="flex items-center gap-2 mb-4 mt-1">
                <i class="ph-fill ph-receipt text-[#37967D] text-xl"></i>
                <h3 class="text-sm font-bold text-gray-900">Rincian Menu</h3>
            </div>

            <div id="cartListContainer" class="space-y-4">
                @foreach($details as $index => $item)
                <div class="flex gap-3 cart-item" id="item-row-{{ $index }}" data-index="{{ $index }}">
                    <div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden shrink-0">
                        @if(isset($item['image_url']) && $item['image_url'])
                            <img src="{{ $item['image_url'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="ph-fill ph-image text-2xl"></i></div>
                        @endif
                    </div>

                    <div class="flex-1 flex flex-col justify-between py-0.5">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-sm text-gray-800 line-clamp-1">{{ $item['name'] }}</h4>
                                <p class="text-[10px] text-gray-400">@ Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <span class="font-bold text-sm text-[#37967D] item-subtotal">Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>

                        <div class="flex items-center gap-3 mt-1">
                            <button type="button" class="btn-action w-6 h-6 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:border-[#37967D] hover:text-[#37967D] transition-colors" data-action="decrease">
                                <i class="ph-bold ph-minus text-[10px] pointer-events-none"></i>
                            </button>
                            <span class="text-sm font-bold text-gray-800 item-qty w-4 text-center">{{ $item['qty'] }}</span>
                            <button type="button" class="btn-action w-6 h-6 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:border-[#37967D] hover:text-[#37967D] transition-colors" data-action="increase">
                                <i class="ph-bold ph-plus text-[10px] pointer-events-none"></i>
                            </button>
                            <button type="button" class="btn-action ml-auto text-red-400 hover:text-red-600 transition-colors" data-action="remove">
                                <i class="ph-fill ph-trash text-lg pointer-events-none"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="border-t-2 border-dashed border-gray-100 my-4"></div>
            <div class="flex justify-between items-center">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Total Item</span>
                <span class="text-sm font-bold text-gray-900" id="totalItemDisplay">{{ count($details) }} Menu</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-[24px] shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <i class="ph-fill ph-wallet text-[#37967D] text-xl"></i>
                <h3 class="text-sm font-bold text-gray-900">Metode Pembayaran</h3>
            </div>
            
            <input type="hidden" name="payment_method" id="paymentMethod" value="tunai">
            <div class="space-y-3">
                <div id="btnTunai" onclick="setPayment('tunai')"
                    class="flex items-center justify-between p-4 rounded-2xl border-2 border-[#37967D] bg-[#37967D]/5 cursor-pointer transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center"><i class="ph-fill ph-money text-xl"></i></div>
                        <div><p class="text-sm font-bold text-gray-800">Tunai</p><p class="text-[10px] text-gray-400">Bayar di kasir</p></div>
                    </div>
                    <div class="w-5 h-5 rounded-full border-2 border-[#37967D] flex items-center justify-center"><div class="w-2.5 h-2.5 rounded-full bg-[#37967D]"></div></div>
                </div>

                <div id="btnQris" onclick="setPayment('qris')"
                    class="flex items-center justify-between p-4 rounded-2xl border-2 border-gray-100 bg-white cursor-pointer transition-all hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center"><i class="ph-fill ph-qr-code text-xl"></i></div>
                        <div><p class="text-sm font-bold text-gray-800">QRIS</p><p class="text-[10px] text-gray-400">Scan barcode</p></div>
                    </div>
                    <div class="w-5 h-5 rounded-full border-2 border-gray-300"></div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 p-5 z-40 max-w-[480px] mx-auto left-0 right-0 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
    <div class="flex items-center justify-between gap-4 mb-4">
        <div class="flex flex-col">
            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Pembayaran</span>
            <span class="text-2xl font-bold text-[#37967D]" id="summaryTotal">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
        </div>
    </div>
    <button type="submit" form="confirmForm" class="bg-[#37967D] text-white w-full py-4 rounded-2xl font-bold text-sm shadow-lg shadow-[#37967D]/25 active:scale-95 transition-transform flex justify-center items-center gap-2 hover:bg-[#2f826c]">
        <span>Simpan Pesanan</span>
        <i class="ph-bold ph-check-circle text-xl"></i>
    </button>
</div>

<div id="init-data" data-cart='{!! json_encode(array_values($details)) !!}' class="hidden"></div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const initData = document.getElementById('init-data');
        let cart = JSON.parse(initData.getAttribute('data-cart'));
        const formatRp = (num) => 'Rp' + num.toLocaleString('id-ID');

        // Render Ulang Cart
        function renderCart() {
            let total = 0;
            let count = 0;
            let finalData = [];

            cart.forEach((item, index) => {
                const row = document.getElementById(`item-row-${index}`);
                if (item.qty > 0) {
                    const subtotal = item.price * item.qty;
                    total += subtotal;
                    count++;
                    if (row) {
                        row.style.display = 'flex';
                        row.querySelector('.item-qty').innerText = item.qty;
                        row.querySelector('.item-subtotal').innerText = formatRp(subtotal);
                    }
                    finalData.push({ id: item.id, qty: item.qty });
                } else {
                    if (row) row.style.display = 'none';
                }
            });

            document.getElementById('summaryTotal').innerText = formatRp(total);
            document.getElementById('totalItemDisplay').innerText = count + ' Menu';
            document.getElementById('cartInput').value = JSON.stringify(finalData);

            if (count === 0) {
                alert('Keranjang kosong, kembali ke menu.');
                window.location.href = "{{ route('orders.create') }}";
            }
        }

        // Event Listener Tombol
        document.getElementById('cartListContainer').addEventListener('click', (e) => {
            const btn = e.target.closest('.btn-action');
            if (!btn) return;
            const index = parseInt(btn.closest('.cart-item').dataset.index);
            const action = btn.dataset.action;

            if (action === 'increase') cart[index].qty++;
            if (action === 'decrease') cart[index].qty > 1 ? cart[index].qty-- : (confirm('Hapus menu ini?') ? cart[index].qty = 0 : null);
            if (action === 'remove') confirm('Hapus menu ini?') ? cart[index].qty = 0 : null;

            renderCart();
        });

        // Setup Fungsi Global
        window.setOrderType = function(type) {
            document.getElementById('orderType').value = type;
            const btnMakan = document.getElementById('btnMakan');
            const btnBungkus = document.getElementById('btnBungkus');
            
            const activeClass = "border-[#37967D] bg-[#37967D]/5 text-[#37967D]";
            const inactiveClass = "border-gray-100 bg-white text-gray-400";

            if(type === 'makan_ditempat') {
                btnMakan.className = `relative flex flex-col items-center justify-center gap-2 py-4 rounded-2xl border-2 transition-all ${activeClass}`;
                btnMakan.querySelector('.absolute').classList.remove('opacity-0');
                btnBungkus.className = `relative flex flex-col items-center justify-center gap-2 py-4 rounded-2xl border-2 transition-all ${inactiveClass}`;
                btnBungkus.querySelector('.absolute').classList.add('opacity-0');
            } else {
                btnBungkus.className = `relative flex flex-col items-center justify-center gap-2 py-4 rounded-2xl border-2 transition-all ${activeClass}`;
                btnBungkus.querySelector('.absolute').classList.remove('opacity-0');
                btnMakan.className = `relative flex flex-col items-center justify-center gap-2 py-4 rounded-2xl border-2 transition-all ${inactiveClass}`;
                btnMakan.querySelector('.absolute').classList.add('opacity-0');
            }
        }

        window.setPayment = function(type) {
            document.getElementById('paymentMethod').value = type;
            const btnTunai = document.getElementById('btnTunai');
            const btnQris = document.getElementById('btnQris');

            const activeClass = "border-[#37967D] bg-[#37967D]/5";
            const inactiveClass = "border-gray-100 bg-white hover:bg-gray-50";

            // Helper untuk update dot radio
            const updateDot = (el, active) => {
                const dotContainer = el.lastElementChild;
                if(active) {
                    dotContainer.className = "w-5 h-5 rounded-full border-2 border-[#37967D] flex items-center justify-center";
                    dotContainer.innerHTML = '<div class="w-2.5 h-2.5 rounded-full bg-[#37967D]"></div>';
                } else {
                    dotContainer.className = "w-5 h-5 rounded-full border-2 border-gray-300";
                    dotContainer.innerHTML = '';
                }
            };

            if(type === 'tunai') {
                btnTunai.className = `flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition-all ${activeClass}`;
                updateDot(btnTunai, true);
                btnQris.className = `flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition-all ${inactiveClass}`;
                updateDot(btnQris, false);
            } else {
                btnQris.className = `flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition-all ${activeClass}`;
                updateDot(btnQris, true);
                btnTunai.className = `flex items-center justify-between p-4 rounded-2xl border-2 cursor-pointer transition-all ${inactiveClass}`;
                updateDot(btnTunai, false);
            }
        }

        renderCart();
    });
</script>
@endsection