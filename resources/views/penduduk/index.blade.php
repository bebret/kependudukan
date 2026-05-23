@extends('app')

@section('title', 'Data Penduduk - SIPENDUK')

@push('styles')
<style>
    /* Styling input text dark mode */
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

    /* Styling dropdown select dark mode */
    .form-select-dark {
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        /* Mengubah warna panah dropdown bawaan Bootstrap agar terlihat di dark mode */
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }
    .form-select-dark:focus {
        background-color: rgba(0, 0, 0, 0.3);
        border-color: var(--accent-blue);
        color: var(--text-main);
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }
    .form-select-dark option {
        background-color: var(--bg-sidebar);
        color: var(--text-main);
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

    /* Pagination */
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
        <h1>Data Penduduk</h1>
        <p>Manajemen data individu penduduk yang terdaftar</p>
    </div>
    <div>
        <a href="{{ route('penduduk.create') }}" class="btn btn-custom-blue">
            <i class="fas fa-plus me-1"></i> Tambah Penduduk
        </a>
    </div>
</div>

<div class="px-4 pb-4">
    
    <div class="card-custom mb-4">
        <div class="d-flex align-items-center mb-3 text-muted" style="font-size: 0.9rem;">
            <i class="fas fa-search me-2"></i> Pencarian & Filter
        </div>
        <form method="GET" action="{{ route('penduduk.index') }}" class="row g-3">
            
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-dark py-2" placeholder="Cari nama atau NIK..." value="{{ request('search') }}">
            </div>
            
            <div class="col-md-2">
                <select name="jenis_kelamin" class="form-select form-select-dark py-2">
                    <option value="">-- Jenis Kelamin --</option>
                    <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="agama" class="form-select form-select-dark py-2">
                    <option value="">-- Agama --</option>
                    <option value="Islam" {{ request('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ request('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ request('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ request('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ request('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Konghucu" {{ request('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="status_hidup" class="form-select form-select-dark py-2">
                    <option value="">-- Status Hidup --</option>
                    <option value="1" {{ request('status_hidup') == '1' ? 'selected' : '' }}>Hidup</option>
                    <option value="0" {{ request('status_hidup') == '0' ? 'selected' : '' }}>Meninggal</option>
                </select>
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
            <span><i class="fas fa-list me-2"></i> Daftar Penduduk ({{ $penduduks->total() ?? 0 }} Data)</span>
        </div>
        
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">NIK</th>
                        <th width="20%">Nama</th>
                        <th width="15%">Jenis Kelamin</th>
                        <th width="15%">Tanggal Lahir</th>
                        <th width="15%">Alamat</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penduduks as $p)
                        <tr>
                            <td>{{ ($penduduks->currentPage() - 1) * $penduduks->perPage() + $loop->iteration }}</td>
                            
                            <td><span style="font-family: monospace; font-size: 0.95rem;">{{ $p->nik }}</span></td>
                            
                            <td><strong>{{ $p->nama }}</strong></td>
                            
                            <td>
                                @if(strtolower($p->jenis_kelamin) == 'laki-laki')
                                    <span class="badge bg-primary px-2 py-1"><i class="fas fa-mars me-1"></i> Laki-laki</span>
                                @else
                                    <span class="badge bg-pink px-2 py-1" style="background-color: #ec4899;"><i class="fas fa-venus me-1"></i> Perempuan</span>
                                @endif
                            </td>
                            
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d-m-Y') }}</td>
                            
                            <td class="text-muted">{{ Str::limit($p->alamat, 20) }}</td>
                            
                            <td class="text-center">
                                <a href="{{ route('penduduk.show', $p) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('penduduk.edit', $p) }}" class="btn btn-sm btn-warning text-dark" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('penduduk.destroy', $p) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data penduduk ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <div style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;">
                                    <i class="fas fa-users-slash"></i>
                                </div>
                                <h5>Tidak ada data penduduk</h5>
                                <p>Silakan sesuaikan filter pencarian atau tambah data baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($penduduks->hasPages())
            <div class="mt-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
                <nav class="d-flex justify-content-center">
                    {{ $penduduks->appends(request()->query())->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        @endif
    </div>

</div>
@endsection