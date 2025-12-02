<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'daily'); // Default: daily

        // Inisialisasi variabel
        $labels = [];
        $dataOmset = [];
        $totalOmset = 0;
        $totalProfit = 0;
        $totalTransaksi = 0;

        // Logika Data Dummy berdasarkan Filter
        switch ($filter) {
            case 'monthly':
                $title = 'Laporan Bulan Ini';
                // Data Tanggal 1 - 30
                for ($i = 1; $i <= 30; $i++) {
                    $labels[] = $i; // Tanggal
                    $val = rand(500000, 2000000); // Random omset 500rb - 2jt
                    $dataOmset[] = $val;
                    $totalOmset += $val;
                    $totalTransaksi += rand(10, 50);
                }
                break;

            case 'yearly':
                $title = 'Laporan Tahun 2025';
                $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                foreach ($months as $month) {
                    $labels[] = $month;
                    $val = rand(10000000, 50000000); // Random omset 10jt - 50jt
                    $dataOmset[] = $val;
                    $totalOmset += $val;
                    $totalTransaksi += rand(300, 1000);
                }
                break;

            case 'daily':
            default:
                $title = 'Laporan Hari Ini';
                // Data Jam 08:00 - 20:00
                $hours = ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00'];
                foreach ($hours as $hour) {
                    $labels[] = $hour;
                    $val = rand(50000, 500000); // Random omset
                    $dataOmset[] = $val;
                    $totalOmset += $val;
                    $totalTransaksi += rand(5, 20);
                }
                break;
        }

        // Hitung Profit (Asumsi 30% dari omset)
        $totalProfit = $totalOmset * 0.3;

        return view('reports.index', compact(
            'filter',
            'title',
            'labels',
            'dataOmset',
            'totalOmset',
            'totalProfit',
            'totalTransaksi'
        ));
    }
}