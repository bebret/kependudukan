<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\HubunganKeluarga;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    /**
     * Display a listing of keluargas
     */
    public function index(Request $request)
    {
        $query = Keluarga::with('kepalKeluarga');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nomor_keluarga', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%")
                  ->orWhereHas('kepalKeluarga', function ($q) use ($search) {
                      $q->where('nama', 'LIKE', "%{$search}%");
                  });
        }

        $keluargas = $query->paginate(15);

        return view('keluarga.index', compact('keluargas'));
    }

    /**
     * Show the form for creating a new keluarga
     */
    public function create()
    {
        // Mencegah Kepala Keluarga yang dipilih adalah orang yang sudah ada di keluarga AKTIF
        // Menggunakan whereHas('keluarga') agar hubungan dari keluarga yang sudah di-soft-delete diabaikan
        $pendudukTerdaftar = HubunganKeluarga::whereHas('keluarga')->pluck('penduduk_id');
        $penduduks = Penduduk::hidup()->whereNotIn('id', $pendudukTerdaftar)->get();
        
        return view('keluarga.create', compact('penduduks'));
    }

    /**
     * Store a newly created keluarga in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_keluarga' => 'required|string|size:16|unique:keluargas',
            'kepala_keluarga_id' => [
                'required',
                'exists:penduduks,id',
                // Validasi agar tidak bisa membuat keluarga baru jika orang tersebut sudah punya keluarga AKTIF
                function ($attribute, $value, $fail) {
                    if (HubunganKeluarga::where('penduduk_id', $value)->whereHas('keluarga')->exists()) {
                        $fail('Penduduk ini sudah terdaftar di keluarga lain.');
                    }
                }
            ],
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
        ]);

        $keluarga = Keluarga::create($validated);

        // Add kepala keluarga as anggota
        HubunganKeluarga::create([
            'penduduk_id' => $validated['kepala_keluarga_id'],
            'keluarga_id' => $keluarga->id,
            'hubungan' => 'Kepala Keluarga',
            'masih_tinggal_bersama' => true,
        ]);

        return redirect()->route('keluarga.show', $keluarga)
                        ->with('success', 'Data keluarga berhasil ditambahkan!');
    }

    /**
     * Display the specified keluarga
     */
    public function show(Keluarga $keluarga)
    {
        $keluarga->load(['kepalKeluarga', 'anggota.penduduk']);
        
        // LAPIS 1: Sembunyikan dari Dropdown Modal
        // Ambil ID semua penduduk yang sudah punya keluarga AKTIF (tidak ter-soft-delete)
        $pendudukTerdaftar = HubunganKeluarga::whereHas('keluarga')->pluck('penduduk_id');
        
        // Tampilkan hanya yang belum punya keluarga aktif
        $penduduks = Penduduk::hidup()
            ->whereNotIn('id', $pendudukTerdaftar)
            ->get();
            
        return view('keluarga.show', compact('keluarga', 'penduduks'));
    }

    /**
     * Show the form for editing the specified keluarga
     */
    public function edit(Keluarga $keluarga)
    {
        $penduduks = Penduduk::hidup()->get();
        return view('keluarga.edit', compact('keluarga', 'penduduks'));
    }

    /**
     * Update the specified keluarga in storage
     */
    public function update(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'nomor_keluarga' => 'required|string|size:16|unique:keluargas,nomor_keluarga,' . $keluarga->id,
            'kepala_keluarga_id' => 'required|exists:penduduks,id',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
        ]);

        $keluarga->update($validated);

        return redirect()->route('keluarga.show', $keluarga)
                        ->with('success', 'Data keluarga berhasil diperbarui!');
    }

    /**
     * Remove the specified keluarga from storage
     */
    public function destroy(Keluarga $keluarga)
    {
        $keluarga->delete();

        return redirect()->route('keluarga.index')
                        ->with('success', 'Data keluarga berhasil dihapus!');
    }

    /**
     * Add anggota to keluarga
     */
    public function addAnggota(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'penduduk_id' => [
                'required',
                'exists:penduduks,id',
                // LAPIS 2: Blokir dari Backend
                // Cek apakah penduduk sudah ada di keluarga LAIN yang AKTIF
                function ($attribute, $value, $fail) use ($keluarga) {
                    $adaDiKeluargaLain = HubunganKeluarga::where('penduduk_id', $value)
                        ->where('keluarga_id', '!=', $keluarga->id)
                        ->whereHas('keluarga') // Memastikan keluarga tujuan memang tidak berstatus terhapus
                        ->exists();

                    if ($adaDiKeluargaLain) {
                        $fail('Gagal! Penduduk ini sudah terdaftar di keluarga lain.');
                    }
                }
            ],
            'hubungan' => 'required|string',
            'masih_tinggal_bersama' => 'boolean',
        ]);

        // 1. Simpan ke variabel dan cari data termasuk yang ter-soft-delete (di keluarga ini)
        $hubungan = HubunganKeluarga::withTrashed()->updateOrCreate(
            [
                'penduduk_id' => $validated['penduduk_id'],
                'keluarga_id' => $keluarga->id,
            ],
            [
                'hubungan' => $validated['hubungan'],
                'masih_tinggal_bersama' => $validated['masih_tinggal_bersama'] ?? true,
            ]
        );

        // 2. Jika datanya berstatus terhapus, aktifkan kembali
        if ($hubungan->trashed()) {
            $hubungan->restore();
        }

        return redirect()->route('keluarga.show', $keluarga)
                        ->with('success', 'Data anggota keluarga berhasil disimpan/diperbarui!');
    }

    /**
     * Remove anggota from keluarga
     */
    public function removeAnggota(Keluarga $keluarga, HubunganKeluarga $hubungan)
    {
        // Prevent removing kepala keluarga
        if ($hubungan->hubungan === 'Kepala Keluarga') {
            return redirect()->route('keluarga.show', $keluarga)
                            ->with('error', 'Tidak dapat menghapus kepala keluarga!');
        }

        $hubungan->delete();

        return redirect()->route('keluarga.show', $keluarga)
                        ->with('success', 'Anggota keluarga berhasil dihapus!');
    }
}