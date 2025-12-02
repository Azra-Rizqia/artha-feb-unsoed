@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="bg-white min-h-screen pb-24">

    {{-- Header dengan Tombol Kembali --}}
    <header class="sticky top-0 z-10 bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-4">
        <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-900 transition">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-900">Notifikasi</h1>

        {{-- Opsional: Badge jumlah belum dibaca --}}
        @php
        $unreadCount = collect($notifications)->where('is_read', false)->count();
        @endphp
        @if($unreadCount > 0)
        <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full">
            {{ $unreadCount }} Baru
        </span>
        @endif
    </header>

    {{-- List Notifikasi --}}
    <div class="flex flex-col">
        @forelse($notifications as $notif)
        {{-- Ubah div menjadi a href --}}
        <a href="{{ route('notifications.show', $notif['id']) }}" class="relative w-full px-6 py-5 border-b border-gray-50 flex gap-4 
                        {{ $notif['is_read'] ? 'bg-white hover:bg-gray-50' : 'bg-[#37967D]/5' }} transition group">
        
            {{-- Indikator Icon --}}
            <div class="flex-shrink-0 mt-1">
                @if(!$notif['is_read'])
                <div class="w-10 h-10 rounded-full bg-[#37967D]/10 flex items-center justify-center text-[#37967D]">
                    <i class="fa-solid fa-bell text-sm"></i>
                </div>
                @else
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                    <i class="fa-regular fa-bell text-sm"></i>
                </div>
                @endif
            </div>
        
            {{-- Konten Text --}}
            <div class="flex-1">
                <div class="flex justify-between items-start mb-1">
                    <h3 class="text-[15px] {{ $notif['is_read'] ? 'font-medium text-gray-600' : 'font-bold text-gray-900' }}">
                        {{ $notif['title'] }}
                    </h3>
        
                    @if(!$notif['is_read'])
                    <span class="w-2 h-2 rounded-full bg-red-500 mt-1.5"></span>
                    @endif
                </div>
        
                <p class="text-sm text-gray-500 leading-relaxed mb-2 line-clamp-2">
                    {{ $notif['body'] }}
                </p>
        
                <p class="text-xs text-gray-400 font-medium">
                    {{ \Carbon\Carbon::parse($notif['created_at'])->locale('id')->diffForHumans() }}
                </p>
            </div>
        
            {{-- Chevron indicator (optional) --}}
            <div class="flex items-center text-gray-300">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </div>
        </a>
        @empty
        {{-- State Kosong --}}
        <div class="flex flex-col items-center justify-center pt-32 text-center px-6">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
                <i class="fa-solid fa-bell-slash text-2xl"></i>
            </div>
            <h3 class="text-gray-900 font-bold mb-1">Tidak ada notifikasi</h3>
            <p class="text-gray-400 text-sm">Saat ini belum ada pemberitahuan baru untuk anda.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection