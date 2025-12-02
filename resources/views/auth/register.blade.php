@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
<div class="w-full">

    {{-- Header (Sama untuk kedua langkah) --}}
    <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        Selamat datang <span class="text-2xl">👋</span>
    </h1>
    <p class="mt-2 text-sm text-gray-500 mb-8">
        Isi data dibawah ini dengan benar untuk mendaftar ke aplikasi kami
    </p>

    {{-- Form Wrapper --}}
    <form action="{{ route('register') }}" method="POST" id="registerForm">
        @csrf

        {{-- ================= STEP 1: Identitas ================= --}}
        <div id="step1" class="space-y-5">

            {{-- Nama Pengguna --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-900 mb-2">Nama pengguna</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#37967D] focus:border-transparent sm:text-sm"
                        placeholder="Masukan nama pengguna">
                </div>
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-900 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#37967D] focus:border-transparent sm:text-sm"
                        placeholder="Masukan email">
                </div>
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Nomor Telpon --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-900 mb-2">Nomor Telpon</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                    </div>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#37967D] focus:border-transparent sm:text-sm"
                        placeholder="Masukan nomor telepon">
                </div>
                @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Tombol Lanjutkan --}}
            <div class="pt-4">
                <button type="button" onclick="nextStep()"
                    class="flex w-full justify-center rounded-xl bg-[#37967D] px-3 py-3.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-[#2a7561] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#37967D]">
                    Lanjutkan
                </button>
            </div>
        </div>

        {{-- ================= STEP 2: Password (Hidden Awalnya) ================= --}}
        <div id="step2" class="hidden space-y-5">

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-900 mb-2">Membuat Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        |**
                    </div>
                    <input type="password" name="password" id="password"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#37967D] focus:border-transparent sm:text-sm"
                        placeholder="Masukan password">
                </div>
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-900 mb-2">Konfirmasi
                    Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        |**
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#37967D] focus:border-transparent sm:text-sm"
                        placeholder="Masukan ulang password">
                </div>
            </div>

            {{-- Tombol Daftar & Kembali --}}
            <div class="pt-4 flex flex-col gap-3">
                <button type="submit"
                    class="flex w-full justify-center rounded-xl bg-[#37967D] px-3 py-3.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-[#2a7561]">
                    Daftar Sekarang
                </button>

                {{-- Tombol Kembali (Opsional, UX yang baik) --}}
                <button type="button" onclick="prevStep()"
                    class="text-sm font-medium text-gray-500 hover:text-gray-700">
                    Kembali
                </button>
            </div>
        </div>

    </form>

    {{-- Footer --}}
    <p class="mt-6 text-center text-sm text-gray-500">
        Dengan mendaftar, Anda menyetujui <a href="#" class="font-medium text-[#37967D]">Persyaratan Layanan</a> dan <a
            href="#" class="font-medium text-[#37967D]">Kebijakan Privasi</a>
    </p>

    <p class="mt-4 text-center text-sm text-gray-500">
        Sudah memiliki akun? <a href="{{ route('login') }}"
            class="font-semibold leading-6 text-[#37967D] hover:text-[#2a7561]">Masuk</a>
    </p>
</div>

{{-- Script Sederhana untuk Pindah Step --}}
<script>
    function nextStep() {
        // Ambil value input step 1 untuk validasi sederhana
        let name = document.getElementById('name').value;
        let email = document.getElementById('email').value;
        let phone = document.getElementById('phone').value;

        if(name === "" || email === "" || phone === "") {
            alert("Harap isi semua data di langkah pertama!");
            return;
        }

        // Sembunyikan step 1, munculkan step 2
        document.getElementById('step1').classList.add('hidden');
        document.getElementById('step2').classList.remove('hidden');
    }

    function prevStep() {
        // Balik ke step 1
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step1').classList.remove('hidden');
    }
</script>
@endsection