@extends('app')

@section('title', 'Detail Penduduk - SIPENDUK')

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
</style>
@endpush

@section('content')

<div class="top-header">
    <div class="d-flex align-items-center gap-3">
        <div style="background-color: rgba(255,255,255,0.1); width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 1.5rem;">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <h1 class="mb-1">Detail Penduduk</h1>
            <p class="mb-0">{{ $penduduk->nama }} (NIK: {{ $penduduk->nik }})</p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('penduduk.edit', $penduduk) }}" class="btn btn-warning text-dark px-4" style="border-radius: 8px; font-weight: 500;">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('penduduk.index') }}" class="btn btn-secondary px-4" style="background-color: rgba(255,255,255,0.1); border: none; border-radius: 8px; font-weight: 500;">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="px-4 pb-5">
    <div class="row g-4">
        
        <div class="col-md-8">
            
            <div class="card-custom mb-4">
                <div class="card-header-custom">
                    <i class="fas fa-address-card"></i> Informasi Personal
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-label">NIK</div>
                        <div class="detail-value" style="font-family: monospace;">{{ $penduduk->nik }}</div>
                        
                        <div class="detail-label">Jenis Kelamin</div>
                        <div class="detail-value">
                            @if(strtolower($penduduk->jenis_kelamin) == 'laki-laki')
                                <span class="badge bg-primary px-3 py-2"><i class="fas fa-mars me-1"></i> Laki-laki</span>
                            @else
                                <span class="badge" style="background-color: #ec4899; padding: 0.5rem 1rem;"><i class="fas fa-venus me-1"></i> Perempuan</span>
                            @endif
                        </div>
                        
                        <div class="detail-label">Tanggal Lahir</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d F Y') }}</div>
                        
                        <div class="detail-label">Agama</div>
                        <div class="detail-value">{{ $penduduk->agama }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-label">Nama Lengkap</div>
                        <div class="detail-value">{{ $penduduk->nama }}</div>
                        
                        <div class="detail-label">Umur</div>
                        <div class="detail-value">
                            <span class="badge bg-info text-dark px-3 py-2">{{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->age }} Tahun</span>
                        </div>
                        
                        <div class="detail-label">Tempat Lahir</div>
                        <div class="detail-value">{{ $penduduk->tempat_lahir }}</div>
                        
                        <div class="detail-label">Status Hidup</div>
                        <div class="detail-value">
                            @if($penduduk->status_hidup)
                                <span class="badge bg-success px-3 py-2">Hidup</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">Meninggal</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-custom mb-4">
                <div class="card-header-custom">
                    <i class="fas fa-map-marker-alt"></i> Alamat
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="detail-label">Alamat Lengkap</div>
                        <div class="detail-value">{{ $penduduk->alamat }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-label">Kelurahan</div>
                        <div class="detail-value">{{ $penduduk->kelurahan ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-label">Kecamatan</div>
                        <div class="detail-value">{{ $penduduk->kecamatan ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-label">Kota/Kabupaten</div>
                        <div class="detail-value">{{ $penduduk->kota ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-label">Provinsi</div>
                        <div class="detail-value">{{ $penduduk->provinsi ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="detail-label">Kode Pos</div>
                        <div class="detail-value">{{ $penduduk->kode_pos ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <div class="card-custom">
                <div class="card-header-custom">
                    <i class="fas fa-briefcase"></i> Pekerjaan & Status
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-label">Status Perkawinan</div>
                        <div class="detail-value">
                            <span class="badge" style="background-color: rgba(16, 185, 129, 0.2); color: var(--success-color); border: 1px solid rgba(16, 185, 129, 0.3); padding: 6px 12px;">
                                {{ $penduduk->status_perkawinan ?? '-' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-label">Pendidikan Terakhir</div>
                        <div class="detail-value">{{ $penduduk->pendidikan ?? '-' }}</div>
                    </div>
                    <div class="col-12 mb-0">
                        <div class="detail-label">Pekerjaan</div>
                        <div class="detail-value mb-0">{{ $penduduk->pekerjaan ?? '-' }}</div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            
            <div class="card-custom mb-4">
                <div class="card-header-custom">
                    <i class="fas fa-info-circle"></i> Informasi Sistem
                </div>
                
                <div class="detail-label">Dibuat Pada</div>
                <div class="detail-value text-muted" style="font-size: 0.95rem;">
                    {{ $penduduk->created_at->translatedFormat('d-m-Y H:i') }} WIB
                </div>
                
                <div class="detail-label">Terakhir Diperbarui</div>
                <div class="detail-value text-muted" style="font-size: 0.95rem;">
                    {{ $penduduk->updated_at->translatedFormat('d-m-Y H:i') }} WIB
                </div>

                <hr style="border-color: var(--border-color); margin: 25px 0;">

                <form action="{{ route('penduduk.destroy', $penduduk) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" style="padding: 12px; border-radius: 8px; font-weight: 500;" onclick="return confirm('Peringatan: Data yang dihapus tidak dapat dikembalikan. Yakin ingin menghapus penduduk ini?')">
                        <i class="fas fa-trash-alt me-2"></i> Hapus Penduduk
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>

@endsection