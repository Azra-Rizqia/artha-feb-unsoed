@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
<div>
    <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        Selamat datang kembali <span class="text-2xl">👋</span>
    </h1>
    <p class="mt-2 text-sm text-gray-500 mb-8">
        Isi data dibawah ini dengan benar untuk masuk ke aplikasi kami
    </p>

    <form action="{{ route('login') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Email / Nama Pengguna --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-900 mb-2">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <input type="email" name="email" id="email" required
                    class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#37967D] focus:border-transparent sm:text-sm"
                    placeholder="Masukan email anda">
            </div>
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-900 mb-2">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    |**
                </div>
                <input type="password" name="password" id="password" required
                    class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#37967D] focus:border-transparent sm:text-sm"
                    placeholder="Masukan password anda">
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="text-sm font-medium text-[#37967D] hover:text-[#2a7561]">Lupa password?</a>
        </div>

        <div>
            <button type="submit"
                class="flex w-full justify-center rounded-xl bg-[#37967D] px-3 py-3.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-[#2a7561] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#37967D]">
                Masuk Sekarang
            </button>
        </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
        Dengan mendaftar, Anda menyetujui <a href="#" class="font-medium text-[#37967D]">Persyaratan Layanan</a> dan <a
            href="#" class="font-medium text-[#37967D]">Kebijakan Privasi</a>
    </p>

    <p class="mt-4 text-center text-sm text-gray-500">
        Belum memiliki akun? <a href="{{ route('register') }}"
            class="font-semibold leading-6 text-[#37967D] hover:text-[#2a7561]">Daftar</a>
    </p>
</div>
@endsection