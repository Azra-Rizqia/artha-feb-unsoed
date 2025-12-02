@extends('layouts.app')

@section('title', 'Chat Admin')

@section('content')
<div class="bg-gray-50 h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-4 shadow-sm z-20">
        <a href="{{ route('profile.index') }}"
            class="text-gray-500 hover:text-gray-900 transition p-1 -ml-1 rounded-full hover:bg-gray-100">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <div class="flex items-center gap-3">
            {{-- Avatar Admin --}}
            <div class="w-10 h-10 rounded-full bg-[#37967D]/10 flex items-center justify-center text-[#37967D]">
                <i class="fa-solid fa-headset text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900 leading-tight">Admin Support</h1>
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-xs text-gray-500">Online</span>
                </div>
            </div>
        </div>
    </header>

    {{-- Chat Area --}}
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6 pb-24 scroll-smooth" id="chatContainer">

        {{-- Tanggal Hari Ini --}}
        <div class="text-center">
            <span class="text-[10px] bg-gray-200 text-gray-500 px-3 py-1 rounded-full">Hari Ini</span>
        </div>

        @foreach($messages as $msg)
        @if($msg['sender'] === 'user')
        {{-- Bubble Chat User (Kanan) --}}
        <div class="flex justify-end">
            <div class="flex flex-col items-end max-w-[80%]">
                <div
                    class="bg-[#37967D] text-white px-5 py-3 rounded-2xl rounded-tr-sm shadow-sm text-sm leading-relaxed">
                    {{ $msg['message'] }}
                </div>
                <span class="text-[10px] text-gray-400 mt-1 mr-1">
                    {{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}
                    <i class="fa-solid fa-check-double text-[#37967D] ml-1"></i>
                </span>
            </div>
        </div>
        @else
        {{-- Bubble Chat Admin (Kiri) --}}
        <div class="flex justify-start">
            <div class="flex flex-col items-start max-w-[80%]">
                <div
                    class="bg-white border border-gray-100 text-gray-700 px-5 py-3 rounded-2xl rounded-tl-sm shadow-sm text-sm leading-relaxed">
                    {{ $msg['message'] }}
                </div>
                <span class="text-[10px] text-gray-400 mt-1 ml-1">
                    {{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}
                </span>
            </div>
        </div>
        @endif
        @endforeach

    </div>

    {{-- Input Area (Sticky Bottom) --}}
    <div class="fixed bottom-0 w-full bg-white border-t border-gray-100 px-4 py-4 z-30">
        <form class="flex items-center gap-3 max-w-md mx-auto lg:max-w-4xl">
            {{-- Tombol Attachment (Opsional) --}}
            <button type="button" class="text-gray-400 hover:text-[#37967D] transition p-2">
                <i class="fa-solid fa-paperclip text-xl"></i>
            </button>

            {{-- Input Field --}}
            <div class="flex-1 relative">
                <input type="text" placeholder="Tulis pesan..."
                    class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-full focus:ring-[#37967D] focus:border-[#37967D] block pl-5 pr-10 py-3 transition"
                    required>
                {{-- Icon Emoticon (Visual) --}}
                <button type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="fa-regular fa-face-smile"></i>
                </button>
            </div>

            {{-- Send Button --}}
            <button type="button"
                class="bg-[#37967D] hover:bg-[#2a7561] text-white rounded-full w-11 h-11 flex items-center justify-center shadow-lg shadow-green-900/10 transition transform active:scale-95">
                <i class="fa-solid fa-paper-plane text-sm translate-x-[-1px] translate-y-[1px]"></i>
            </button>
        </form>
    </div>

</div>

<script>
    // Auto scroll ke bawah saat halaman dimuat
    window.onload = function() {
        const chatContainer = document.getElementById('chatContainer');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
</script>
@endsection