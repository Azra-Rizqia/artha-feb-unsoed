@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')

<div class="sticky top-0 bg-white z-20 px-6 pt-8 pb-4 flex items-center justify-between shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
    <a href="{{ route('menu.index') }}" class="text-gray-800 hover:text-[#37967D] transition-colors">
        <i class="ph ph-caret-left text-2xl"></i>
    </a>
    <h1 class="text-lg font-bold text-gray-900">Detail Produk</h1>
    <button class="text-gray-800 hover:text-[#37967D] transition-colors">
        <i class="ph ph-info text-2xl"></i>
    </button>
</div>

<div class="px-6 pb-32 pt-4">
    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf

        <div class="mb-5">
            <label class="block text-gray-900 font-bold text-[13px] mb-2">Nama Produk</label>
            <input type="text" name="nama_produk" id="inputName" required
                class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-3.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] transition-all form-input"
                placeholder="Isi nama produk">
        </div>

        <div class="mb-5">
            <label class="block text-gray-900 font-bold text-[13px] mb-2">Gambar Produk</label>
            <div class="relative w-full h-32 border-2 border-dashed border-gray-200 rounded-2xl bg-white flex flex-col items-center justify-center text-center cursor-pointer hover:bg-gray-50 transition-colors group overflow-hidden">
                <input type="file" name="image" id="inputImage" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10 form-input" accept="image/*" required>
                
                <div id="imagePlaceholder" class="flex flex-col items-center pointer-events-none">
                    <div class="w-10 h-10 bg-[#37967D]/10 rounded-full flex items-center justify-center mb-2">
                        <i class="ph ph-cloud-arrow-up text-[#37967D] text-xl"></i>
                    </div>
                    <p class="text-xs font-bold text-gray-700">Upload Gambar</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">PNG, JPG atau JPEG (Maks 10MB)</p>
                </div>
                <img id="imagePreview" class="absolute inset-0 w-full h-full object-cover hidden" />
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-gray-900 font-bold text-[13px] mb-2">Keterangan Produk</label>
            <input type="text" name="deskripsi" id="inputDesc" required
                class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-3.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] transition-all form-input"
                placeholder="Isi keterangan produk">
        </div>

        <div class="mb-5">
            <label class="block text-gray-900 font-bold text-[13px] mb-2">Kategori Produk</label>
            <div class="flex flex-wrap gap-2">
                @php $categories = ['Nasi', 'Minuman', 'Mie', 'Jajanan', 'Lainnya']; @endphp
                @foreach($categories as $cat)
                <label class="cursor-pointer">
                    <input type="radio" name="kategori" value="{{ $cat }}" class="peer hidden form-input" required>
                    {{-- Style: Default Abu-abu, Checked: Border Hijau & Text Hijau --}}
                    <div class="px-5 py-2.5 rounded-xl border border-transparent bg-gray-100 text-xs font-medium text-gray-500 peer-checked:bg-white peer-checked:border-[#37967D] peer-checked:text-[#37967D] transition-all">
                        {{ $cat }}
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-gray-900 font-bold text-[13px] mb-2">Stok Produk</label>
            <input type="number" name="stock" id="inputStock" required
                class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-3.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] transition-all form-input"
                placeholder="Isi stok produk">
        </div>

        <div class="mb-5">
            <label class="block text-gray-900 font-bold text-[13px] mb-2">Harga Modal</label>
            <input type="number" name="harga_modal" id="hargaModal" required
                class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-3.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] transition-all form-input"
                placeholder="Isi harga modal">
        </div>

        <div class="mb-5">
            <label class="block text-gray-900 font-bold text-[13px] mb-2">Persentase Keuntungan</label>
            <div class="flex flex-wrap gap-2 mb-2">
                @foreach([10, 20, 30] as $percent)
                <label class="cursor-pointer flex-1">
                    <input type="radio" name="persen_keuntungan" value="{{ $percent }}" class="peer hidden percent-radio form-input" required>
                    <div class="w-full text-center py-2.5 rounded-xl border border-transparent bg-gray-100 text-xs font-medium text-gray-500 peer-checked:bg-white peer-checked:border-[#37967D] peer-checked:text-[#37967D] transition-all">
                        {{ $percent }}%
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-gray-900 font-bold text-[13px] mb-2">Harga Jual</label>
            <input type="text" id="hargaJualDisplay" readonly
                class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3.5 text-sm text-gray-400 focus:outline-none cursor-not-allowed"
                placeholder="Isi harga jual">
        </div>

        <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 p-5 z-50 max-w-[480px] mx-auto left-0 right-0">
            <button type="submit" id="submitBtn" disabled
                class="w-full font-bold py-4 rounded-2xl transition-all duration-300
                       bg-gray-200 text-gray-400 cursor-not-allowed">
                Unggah Produk
            </button>
        </div>
    </form>
</div>

@if(session('product_added'))
<div class="fixed inset-0 z-50 flex items-center justify-center px-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    
    <div class="bg-white rounded-3xl p-6 w-full max-w-[320px] relative z-10 flex flex-col items-center text-center shadow-2xl animate-bounce-in">
        
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-4 relative">
            <div class="w-12 h-12 bg-[#00C566] rounded-full flex items-center justify-center shadow-lg shadow-green-200">
                <i class="ph-bold ph-check text-white text-2xl"></i>
            </div>
            <div class="absolute top-2 right-1 text-[#00C566] text-xs"><i class="ph-fill ph-triangle"></i></div>
            <div class="absolute bottom-2 left-1 text-[#00C566] text-xs"><i class="ph-fill ph-circle"></i></div>
        </div>

        <h3 class="text-lg font-bold text-gray-900 mb-2">Menu berhasil ditambah</h3>
        <p class="text-[12px] text-gray-500 leading-relaxed mb-6">
            Anda dapat mengecek menu baru di<br>halaman menu
        </p>

        <a href="{{ route('menu.index') }}" class="w-full bg-[#37967D] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-[#37967D]/20 active:scale-95 transition-transform">
            Lihat Menu
        </a>
    </div>
</div>
@endif

{{-- Script Logic --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const formInputs = document.querySelectorAll('.form-input');
        const submitBtn = document.getElementById('submitBtn');
        
        const imageInput = document.getElementById('inputImage');
        const imagePreview = document.getElementById('imagePreview');
        const imagePlaceholder = document.getElementById('imagePlaceholder');
        
        const hargaModalInput = document.getElementById('hargaModal');
        const hargaJualDisplay = document.getElementById('hargaJualDisplay');
        const percentRadios = document.querySelectorAll('.percent-radio');
        let currentPercent = 0;

        // 1. Logic Cek Kelengkapan Form (Validation UI)
        function checkFormCompletion() {
            let allFilled = true;
            
            // Cek semua input yang punya class 'form-input'
            formInputs.forEach(input => {
                if (input.type === 'radio') {
                    // Untuk radio, cek group name
                    const group = document.getElementsByName(input.name);
                    let groupChecked = false;
                    group.forEach(radio => {
                        if (radio.checked) groupChecked = true;
                    });
                    if (!groupChecked) allFilled = false;
                } else {
                    // Untuk text/number/file
                    if (!input.value) allFilled = false;
                }
            });

            // Update Style Tombol
            if (allFilled) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-gray-200', 'text-gray-400', 'cursor-not-allowed');
                submitBtn.classList.add('bg-[#37967D]', 'text-white', 'shadow-lg', 'shadow-[#37967D]/20', 'active:scale-95');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('bg-gray-200', 'text-gray-400', 'cursor-not-allowed');
                submitBtn.classList.remove('bg-[#37967D]', 'text-white', 'shadow-lg', 'shadow-[#37967D]/20', 'active:scale-95');
            }
        }

        // Pasang listener ke semua input
        formInputs.forEach(input => {
            input.addEventListener('input', checkFormCompletion);
            input.addEventListener('change', checkFormCompletion);
        });

        // 2. Preview Image
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    imagePlaceholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
            checkFormCompletion();
        });

        // 3. Hitung Harga Otomatis
        function calculatePrice() {
            const modal = parseFloat(hargaModalInput.value) || 0;
            if (currentPercent > 0 && modal > 0) {
                const jual = modal + (modal * (currentPercent / 100));
                hargaJualDisplay.value = "Rp " + jual.toLocaleString('id-ID');
            } else {
                hargaJualDisplay.value = "";
            }
        }

        hargaModalInput.addEventListener('input', calculatePrice);

        percentRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                currentPercent = parseFloat(e.target.value);
                calculatePrice();
            });
        });
    });
</script>

<style>
    /* Animasi Popup */
    @keyframes bounce-in {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); }
    }
    .animate-bounce-in {
        animation: bounce-in 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
</style>

@endsection