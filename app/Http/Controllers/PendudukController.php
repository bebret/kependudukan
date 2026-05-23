<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    /**
     * Display a listing of penduduk
     */
    public function index(Request $request)
    {
        $query = Penduduk::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%");
        }

        // Filter by jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->input('jenis_kelamin'));
        }

        // Filter by agama
        if ($request->filled('agama')) {
            $query->where('agama', $request->input('agama'));
        }

        // Filter by status perkawinan
        if ($request->filled('status_perkawinan')) {
            $query->where('status_perkawinan', $request->input('status_perkawinan'));
        }

        // Filter by status hidup
        if ($request->filled('status_hidup')) {
            $query->where('status_hidup', $request->input('status_hidup'));
        }

        // Sorting
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        $query->orderBy($sort, $direction);

        $penduduks = $query->paginate(15);

        return view('penduduk.index', compact('penduduks'));
    }

    /**
     * Show the form for creating a new penduduk
     */
    public function create()
    {
        return view('penduduk.create');
    }

    /**
     * Store a newly created penduduk in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduks',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|size:5',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'pendidikan' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        Penduduk::create($validated);

        return redirect()->route('penduduk.index')
                        ->with('success', 'Data penduduk berhasil ditambahkan!');
    }

    /**
     * Display the specified penduduk
     */
    public function show(Penduduk $penduduk)
    {
        return view('penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified penduduk
     */
    public function edit(Penduduk $penduduk)
    {
        return view('penduduk.edit', compact('penduduk'));
    }

    /**
     * Update the specified penduduk in storage
     */
    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduks,nik,' . $penduduk->id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|size:5',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'pendidikan' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'status_hidup' => 'required|in:Hidup,Mati',
        ]);

        $penduduk->update($validated);

        return redirect()->route('penduduk.show', $penduduk)
                        ->with('success', 'Data penduduk berhasil diperbarui!');
    }

    /**
     * Remove the specified penduduk from storage
     */
    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();

        return redirect()->route('penduduk.index')
                        ->with('success', 'Data penduduk berhasil dihapus!');
    }
}
