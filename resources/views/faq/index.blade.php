@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="bg-white min-h-screen pb-24">

    {{-- Header --}}
    <header class="sticky top-0 z-10 bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-4">
        <a href="{{ route('profile.index') }}"
            class="text-gray-500 hover:text-gray-900 transition p-1 -ml-1 rounded-full hover:bg-gray-100">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-900">Pertanyaan Umum</h1>
    </header>

    {{-- Search Bar --}}
    <div class="px-6 pt-6 pb-2">
        <div class="relative group">
            <div
                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#37967D] transition">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <input type="text"
                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-[#37967D] focus:ring-1 focus:ring-[#37967D] sm:text-sm transition bg-gray-50 focus:bg-white"
                placeholder="Cari topik bantuan...">
        </div>
    </div>

    {{-- Content List --}}
    <div class="px-6">
        @foreach($faqs as $groupIndex => $group)

        {{-- Category Title --}}
        <h2 class="mt-8 mb-3 text-xs font-bold text-gray-400 uppercase tracking-widest pl-1">
            {{ $group['category'] }}
        </h2>

        <div class="space-y-3">
            @foreach($group['items'] as $itemIndex => $item)
            {{-- Unique ID generation --}}
            @php $id = $groupIndex . '-' . $itemIndex; @endphp

            {{-- Accordion Item --}}
            <div
                class="border border-gray-100 rounded-xl overflow-hidden bg-white shadow-sm hover:shadow-md transition-all duration-300">

                {{-- Question (Button) --}}
                <button onclick="toggleFaq('{{ $id }}')"
                    class="w-full flex items-center justify-between px-5 py-4 bg-white hover:bg-gray-50 text-left transition group cursor-pointer">
                    <span class="font-semibold text-gray-800 text-[15px] group-hover:text-[#37967D] transition pr-4">
                        {{ $item['question'] }}
                    </span>
                    {{-- Icon Chevron --}}
                    <div
                        class="w-6 h-6 rounded-full bg-gray-50 flex items-center justify-center flex-shrink-0 group-hover:bg-[#37967D]/10 transition">
                        <i id="icon-{{ $id }}"
                            class="fa-solid fa-chevron-down text-gray-400 text-[10px] transition-transform duration-300 group-hover:text-[#37967D]"></i>
                    </div>
                </button>

                {{-- Answer (Hidden by default) --}}
                <div id="body-{{ $id }}"
                    class="hidden bg-gray-50/50 px-5 py-4 text-[14px] text-gray-600 leading-relaxed border-t border-gray-100">
                    {{ $item['answer'] }}
                </div>

            </div>
            @endforeach
        </div>
        @endforeach
    </div>

    {{-- Footer Info --}}
    <div class="mt-12 mb-8 text-center px-6">
        <p class="text-sm text-gray-400 mb-4">Tidak menemukan jawaban?</p>
        <a href="{{ route('qna.index') }}"
            class="inline-flex items-center gap-2 text-white font-bold text-sm bg-[#37967D] px-6 py-3 rounded-xl shadow-lg shadow-green-900/10 hover:bg-[#2a7561] transition active:scale-95">
            <i class="fa-solid fa-headset"></i>
            Chat dengan Admin
        </a>
    </div>

</div>

{{-- Script Accordion --}}
<script>
    function toggleFaq(id) {
        const body = document.getElementById('body-' + id);
        const icon = document.getElementById('icon-' + id);

        // Jika sedang tertutup, buka
        if (body.classList.contains('hidden')) {
            // Opsional: Tutup semua yang lain agar rapi (Single expand)
            document.querySelectorAll('[id^="body-"]').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('[id^="icon-"]').forEach(el => el.classList.remove('rotate-180'));

            body.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            // Jika sedang terbuka, tutup
            body.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>
@endsection