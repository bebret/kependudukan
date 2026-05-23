@extends('app')

@section('title', 'Detail Keluarga - SIPENDUK')

@push('styles')
<style>
    /* Styling khusus teks detail */
    .detail-label {
        color: var(--text-muted);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }
    .detail-value {
        color: var(--text-main);
        font-size: 1.05rem;
        font-weight: 500;
        margin-bottom: 20px;
    }
    
    /* Styling Header Card */
    .card-header-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
        margin-bottom: 20px;
        font-weight: 600;
        color: var(--text-main);
        font-size: 1.1rem;
    }
    .card-header-custom i {
        color: var(--text-muted);
        margin-right: 10px;
    }

    /* Tabel Anggota Dark Mode */
    .table-custom {
        color: var(--text-main);
        margin-bottom: 0;
    }
    .table-custom thead th {
        background-color: rgba(255, 255, 255, 0.03);
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-color);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 12px 15px;
    }
    .table-custom tbody td {
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        padding: 12px 15px;
    }
    .table-custom tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.02);
    }

    /* Modal Dark Mode */
    .modal-content-dark {
        background-color: var(--bg-sidebar);
        color: var(--text-main);
        border: 1px solid var(--border-color);
    }
    .modal-header-dark {
        border-bottom: 1px solid var(--border-color);
    }
    .modal-footer-dark {
        border-top: 1px solid var(--border-color);
    }
    
    .form-label-custom { color: var(--text-muted); font-size: 0.85rem; margin-bottom: 8px; display: block; }
    .form-select-dark {
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }
    .form-select-dark:focus {
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }
    .form-select-dark option { background-color: var(--bg-sidebar); }
</style>
@endpush

@section('content')

<div class="top-header">
    <div class="d-flex align-items-center gap-3">
        <div style="background-color: rgba(255,255,255,0.1); width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1.5rem;">
            <i class="fas fa-home"></i>
        </div>
        <div>
            <h1 class="mb-1">Detail Keluarga</h1>
            <p class="mb-0">No. Keluarga: {{ $keluarga->nomor_keluarga }}</p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('keluarga.edit', $keluarga) }}" class="btn btn-warning text-dark px-4" style="border-radius: 8px; font-weight: 500;">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('keluarga.index') }}" class="btn btn-secondary px-4" style="background-color: rgba(255,255,255,0.1); border: none; border-radius: 8px; font-weight: 500;">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="px-4 pb-5">
    <div class="row g-4">
        
        <div class="col-md-8">
            
            <div class="card-custom mb-4">
                <div class="card-header-custom">
                    <div><i class="fas fa-info-circle"></i> Informasi Keluarga</div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-label">No. Keluarga</div>
                        <div class="detail-value" style="font-family: monospace;">{{ $keluarga->nomor_keluarga }}</div>
                        
                        <div class="detail-label">Alamat Lengkap</div>
                        <div class="detail-value">{{ $keluarga->alamat }}</div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="detail-label">Kelurahan</div>
                                <div class="detail-value">{{ $keluarga->kelurahan }}</div>
                            </div>
                            <div class="col-6">
                                <div class="detail-label">Kecamatan</div>
                                <div class="detail-value">{{ $keluarga->kecamatan }}</div>
                            </div>
                        </div>

                        <div class="detail-label">Jumlah Anggota</div>
                        <div class="detail-value">
                            <span class="badge" style="background-color: rgba(59, 130, 246, 0.2); color: #93c5fd; padding: 6px 12px; border: 1px solid rgba(59, 130, 246, 0.3);">
                                {{ $keluarga->anggota->count() }} Orang
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-label">Kepala Keluarga</div>
                        <div class="detail-value">
                            <strong>{{ $keluarga->kepalKeluarga?->nama ?? '-' }}</strong><br>
                            <span class="text-muted" style="font-size: 0.85rem;">NIK: {{ $keluarga->kepalKeluarga?->nik ?? '-' }}</span>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="detail-label">Kota/Kabupaten</div>
                                <div class="detail-value">{{ $keluarga->kota }}</div>
                            </div>
                            <div class="col-6">
                                <div class="detail-label">Provinsi</div>
                                <div class="detail-value">{{ $keluarga->provinsi }}</div>
                            </div>
                        </div>

                        <div class="detail-label">Tanggal Terdaftar</div>
                        <div class="detail-value">{{ $keluarga->created_at->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="card-custom">
                <div class="card-header-custom">
                    <div><i class="fas fa-users"></i> Anggota Keluarga ({{ $keluarga->anggota->count() }} orang)</div>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#tambahAnggotaModal">
                        <i class="fas fa-plus me-1"></i> Tambah Anggota
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>L/P</th>
                                <th>Hubungan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keluarga->anggota as $anggota)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="font-family: monospace; font-size: 0.9rem;">{{ $anggota->penduduk->nik }}</td>
                                    <td><strong>{{ $anggota->penduduk->nama }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($anggota->penduduk->tanggal_lahir)->age }} thn</td>
                                    <td>
                                        @if(strtolower($anggota->penduduk->jenis_kelamin) == 'laki-laki')
                                            <span class="badge bg-primary px-2 py-1">L</span>
                                        @else
                                            <span class="badge" style="background-color: #ec4899; padding: 0.25rem 0.5rem;">P</span>
                                        @endif
                                    </td>
                                    <td>{{ $anggota->hubungan }}</td>
                                    <td>
                                        <a href="{{ route('penduduk.show', $anggota->penduduk) }}" class="btn btn-sm btn-info text-white" title="Lihat Penduduk">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($anggota->hubungan !== 'Kepala Keluarga')
                                            <form action="{{ route('keluarga.removeAnggota', [$keluarga, $anggota]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Keluarkan anggota ini dari keluarga?')" title="Keluarkan">
                                                    <i class="fas fa-user-minus"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada data anggota keluarga.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="card-custom mb-4">
                <div class="card-header-custom">
                    <div><i class="fas fa-server"></i> Informasi Sistem</div>
                </div>
                
                <div class="detail-label">Dibuat Pada</div>
                <div class="detail-value" style="font-size: 0.95rem; color: var(--text-main);">
                    {{ $keluarga->created_at->translatedFormat('d-m-Y H:i') }}
                </div>
                
                <div class="detail-label">Terakhir Diperbarui</div>
                <div class="detail-value" style="font-size: 0.95rem; color: var(--text-main);">
                    {{ $keluarga->updated_at->translatedFormat('d-m-Y H:i') }}
                </div>

                <hr style="border-color: var(--border-color); margin: 25px 0;">

                <form action="{{ route('keluarga.destroy', $keluarga) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" style="padding: 12px; border-radius: 8px; font-weight: 500;" onclick="return confirm('Peringatan: Seluruh data keluarga ini akan dihapus. Yakin?')">
                        <i class="fas fa-trash-alt me-2"></i> Hapus Keluarga
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="tambahAnggotaModal" tabindex="-1" aria-labelledby="tambahAnggotaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-content-dark">
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title" id="tambahAnggotaModalLabel">Tambah Anggota Keluarga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('keluarga.addAnggota', $keluarga) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label-custom">Pilih Penduduk</label>
                        <select name="penduduk_id" class="form-select form-select-dark" required>
                            <option value="">-- Pilih Penduduk --</option>
                            @foreach($penduduks as $p)
                                <option value="{{ $p->id }}">{{ $p->nik }} - {{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Hubungan Keluarga</label>
                        <select name="hubungan" class="form-select form-select-dark" required>
                            <option value="">-- Pilih Hubungan --</option>
                            <option value="Istri/Suami">Istri/Suami</option>
                            <option value="Anak">Anak</option>
                            <option value="Menantu">Menantu</option>
                            <option value="Cucu">Cucu</option>
                            <option value="Orang Tua">Orang Tua</option>
                            <option value="Mertua">Mertua</option>
                            <option value="Famili Lain">Famili Lain</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Status Tinggal</label>
                        <select name="masih_tinggal_bersama" class="form-select form-select-dark" required>
                            <option value="1">Masih Tinggal Bersama</option>
                            <option value="0">Tidak Tinggal Bersama</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer modal-footer-dark">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-custom-blue"><i class="fas fa-save me-1"></i> Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection