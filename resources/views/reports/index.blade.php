@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="bg-gray-50 min-h-screen pb-24">

    {{-- Header --}}
    <header class="sticky top-0 z-10 bg-white border-b border-gray-100 px-6 py-4 flex items-center gap-4">
        <a href="{{ route('profile.index') }}"
            class="text-gray-500 hover:text-gray-900 transition p-1 -ml-1 rounded-full hover:bg-gray-100">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-900">Laporan Keuangan</h1>
    </header>

    <div class="px-6 py-6">

        {{-- Filter Tabs (Harian / Bulanan / Tahunan) --}}
        <div class="bg-gray-200 p-1 rounded-xl flex mb-6">
            <a href="{{ route('reports.index', ['filter' => 'daily']) }}"
                class="flex-1 text-center py-2 text-sm font-bold rounded-lg transition {{ $filter === 'daily' ? 'bg-white text-[#37967D] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Harian
            </a>
            <a href="{{ route('reports.index', ['filter' => 'monthly']) }}"
                class="flex-1 text-center py-2 text-sm font-bold rounded-lg transition {{ $filter === 'monthly' ? 'bg-white text-[#37967D] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Bulanan
            </a>
            <a href="{{ route('reports.index', ['filter' => 'yearly']) }}"
                class="flex-1 text-center py-2 text-sm font-bold rounded-lg transition {{ $filter === 'yearly' ? 'bg-white text-[#37967D] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Tahunan
            </a>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            {{-- Total Omset --}}
            <div
                class="col-span-2 bg-[#37967D] text-white p-5 rounded-2xl shadow-lg shadow-green-900/20 relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-green-100 text-sm font-medium mb-1">Total Pemasukan</p>
                    <h2 class="text-3xl font-bold">Rp{{ number_format($totalOmset, 0, ',', '.') }}</h2>
                </div>
                {{-- Decoration --}}
                <i class="fa-solid fa-wallet absolute -bottom-4 -right-4 text-8xl text-white opacity-10"></i>
            </div>

            {{-- Profit --}}
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mb-3">
                    <i class="fa-solid fa-chart-line text-xs"></i>
                </div>
                <p class="text-gray-400 text-xs font-medium">Total Profit</p>
                <h3 class="text-lg font-bold text-gray-900">Rp{{ number_format($totalProfit, 0, ',', '.') }}</h3>
            </div>

            {{-- Transaksi --}}
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 mb-3">
                    <i class="fa-solid fa-receipt text-xs"></i>
                </div>
                <p class="text-gray-400 text-xs font-medium">Total Transaksi</p>
                <h3 class="text-lg font-bold text-gray-900">{{ number_format($totalTransaksi) }}x</h3>
            </div>
        </div>

        {{-- Chart Section --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm mb-6">
            <h3 class="font-bold text-gray-900 mb-4">Grafik Penjualan</h3>
            <div class="relative h-64 w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Top Products (Dummy List) --}}
        <h3 class="font-bold text-gray-900 mb-3">Produk Terlaris</h3>
        <div class="space-y-3">
            @foreach(['Nasi Goreng Spesial', 'Ayam Bakar Madu', 'Es Teh Manis'] as $index => $item)
            <div class="bg-white p-4 rounded-xl border border-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-500 text-xs">
                        #{{ $index + 1 }}
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">{{ $item }}</h4>
                        <p class="text-xs text-gray-400">{{ rand(50, 200) }} terjual</p>
                    </div>
                </div>
                <span class="text-sm font-bold text-[#37967D]">+{{ rand(10, 30) }}%</span>
            </div>
            @endforeach
        </div>

    </div>
</div>

{{-- Load Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('salesChart');

    // Data dari Controller
    const labels = @json($labels);
    const dataOmset = @json($dataOmset);

    new Chart(ctx, {
        type: 'line', // Menggunakan Line Chart agar terlihat tren-nya
        data: {
            labels: labels,
            datasets: [{
                label: 'Omset (Rp)',
                data: dataOmset,
                borderColor: '#37967D', // Warna Garis Hijau Artha
                backgroundColor: 'rgba(55, 150, 125, 0.1)', // Warna Arsiran bawah
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#37967D',
                pointRadius: 4,
                tension: 0.4, // Membuat garis melengkung halus (spline)
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Sembunyikan legenda agar bersih
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1f2937',
                    bodyColor: '#37967D',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false // Sembunyikan garis grid vertikal
                    },
                    ticks: {
                        font: { size: 10 }
                    }
                },
                y: {
                    beginAtZero: true,
                    border: { display: false },
                    grid: {
                        color: '#f3f4f6',
                        borderDash: [5, 5] // Garis putus-putus
                    },
                    ticks: {
                        display: false // Sembunyikan angka di sumbu Y agar bersih
                    }
                }
            }
        }
    });
</script>
@endsection