@extends('app')

@section('title', 'Data Keluarga - SIPENDUK')

@push('styles')
<style>
    /* Styling khusus input pencarian dark mode */
    .form-control-dark {
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-color);
        color: var(--text-main);
    }
    .form-control-dark:focus {
        background-color: rgba(0, 0, 0, 0.3);
        border-color: var(--accent-blue);
        color: var(--text-main);
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }
    .form-control-dark::placeholder {
        color: var(--text-muted);
    }

    /* Styling tabel dark mode */
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
        letter-spacing: 0.5px;
        padding: 12px 15px;
    }
    .table-custom tbody td {
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        padding: 15px;
    }
    .table-custom tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.02);
    }

    /* Kustomisasi Pagination Bootstrap untuk Dark Mode */
    .pagination {
        --bs-pagination-bg: var(--bg-sidebar);
        --bs-pagination-border-color: var(--border-color);
        --bs-pagination-color: var(--text-main);
        --bs-pagination-hover-bg: rgba(255, 255, 255, 0.05);
        --bs-pagination-hover-border-color: var(--border-color);
        --bs-pagination-hover-color: var(--text-main);
        --bs-pagination-active-bg: var(--accent-blue);
        --bs-pagination-active-border-color: var(--accent-blue);
        --bs-pagination-disabled-bg: rgba(0,0,0,0.1);
        --bs-pagination-disabled-border-color: var(--border-color);
    }
</style>
@endpush

@section('content')

<div class="top-header">
    <div>
        <h1>Data Keluarga</h1>
        <p>Manajemen data Kartu Keluarga terdaftar</p>
    </div>
    <div>
        <a href="{{ route('keluarga.create') }}" class="btn btn-custom-blue">
            <i class="fas fa-plus me-1"></i> Tambah Keluarga
        </a>
    </div>
</div>

<div class="px-4 pb-4">
    
    <div class="card-custom mb-4">
        <div class="d-flex align-items-center mb-3 text-muted" style="font-size: 0.9rem;">
            <i class="fas fa-search me-2"></i> Area Pencarian
        </div>
        <form method="GET" action="{{ route('keluarga.index') }}" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control form-control-dark py-2" placeholder="Cari nomor keluarga atau nama kepala keluarga..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-custom-blue w-100 py-2">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <div class="card-custom">
        <div class="d-flex align-items-center justify-content-between mb-3 text-muted" style="font-size: 0.9rem;">
            <span><i class="fas fa-list me-2"></i> Daftar Keluarga ({{ $keluargas->total() }} Data)</span>
        </div>
        
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">No. Keluarga</th>
                        <th width="25%">Kepala Keluarga</th>
                        <th width="25%">Alamat</th>
                        <th width="10%">Anggota</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keluargas as $k)
                        <tr>
                            <td>{{ ($keluargas->currentPage() - 1) * $keluargas->perPage() + $loop->iteration }}</td>
                            <td><span style="font-family: monospace; font-size: 1rem;">{{ $k->nomor_keluarga }}</span></td>
                            <td>
                                <strong>{{ $k->kepalKeluarga?->nama ?? '-' }}</strong>
                            </td>
                            <td class="text-muted">{{ Str::limit($k->alamat, 30) }}</td>
                           <td>
                                <span class="badge" style="background-color: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3); padding: 6px 10px;">
                                    <i class="fas fa-users me-1"></i> {{ $k->jumlah_anggota ?? 0 }} Orang
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('keluarga.show', $k) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('keluarga.edit', $k) }}" class="btn btn-sm btn-warning text-dark" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('keluarga.destroy', $k) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data keluarga ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <div style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h5>Tidak ada data keluarga</h5>
                                <p>Silakan sesuaikan filter pencarian atau tambah data baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($keluargas->hasPages())
            <div class="mt-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
                <nav class="d-flex justify-content-center">
                    {{ $keluargas->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        @endif
    </div>

</div>
@endsection