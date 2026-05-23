<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Keluarga;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $statistik = [
            'total_penduduk' => Penduduk::count(),
            'penduduk_hidup' => Penduduk::hidup()->count(),
            'penduduk_mati' => Penduduk::where('status_hidup', 'Mati')->count(),
            'laki_laki' => Penduduk::where('jenis_kelamin', 'Laki-laki')->count(),
            'perempuan' => Penduduk::where('jenis_kelamin', 'Perempuan')->count(),
            'total_keluarga' => Keluarga::count(),
            'belum_kawin' => Penduduk::where('status_perkawinan', 'Belum Kawin')->count(),
            'kawin' => Penduduk::where('status_perkawinan', 'Kawin')->count(),
        ];

        // Statistik agama
        $agama = Penduduk::selectRaw('agama, COUNT(*) as jumlah')
                        ->whereNotNull('agama')
                        ->groupBy('agama')
                        ->get();

        // Statistik pendidikan
        $pendidikan = Penduduk::selectRaw('pendidikan, COUNT(*) as jumlah')
                             ->whereNotNull('pendidikan')
                             ->groupBy('pendidikan')
                             ->take(10)
                             ->get();

        // Statistik pekerjaan
        $pekerjaan = Penduduk::selectRaw('pekerjaan, COUNT(*) as jumlah')
                            ->whereNotNull('pekerjaan')
                            ->groupBy('pekerjaan')
                            ->take(10)
                            ->get();

        // Penduduk terbaru
        $pendudukTerbaru = Penduduk::latest()->take(5)->get();

        return view('dashboard', compact('statistik', 'agama', 'pendidikan', 'pekerjaan', 'pendudukTerbaru'));
    }
}
