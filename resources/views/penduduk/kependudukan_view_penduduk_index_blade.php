@extends('app')

@section('title', 'Data Penduduk')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1><i class="fas fa-users"></i> Data Penduduk</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('penduduk.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Penduduk
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-search"></i> Pencarian & Filter
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('penduduk.index') }}" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau NIK..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="jenis_kelamin" class="form-select">
                    <option value="">-- Jenis Kelamin --</option>
                    <option value="Laki-laki" {{ request('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="Perempuan" {{ request('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="agama" class="form-select">
                    <option value="">-- Agama --</option>
                    <option value="Islam" {{ request('agama') === 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ request('agama') === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ request('agama') === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ request('agama') === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Budha" {{ request('agama') === 'Budha' ? 'selected' : '' }}>Budha</option>
                    <option value="Konghucu" {{ request('agama') === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status_hidup" class="form-select">
                    <option value="">-- Status Hidup --</option>
                    <option value="Hidup" {{ request('status_hidup') === 'Hidup' ? 'selected' : '' }}>Hidup</option>
                    <option value="Mati" {{ request('status_hidup') === 'Mati' ? 'selected' : '' }}>Mati</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-info w-100">
                    <i class="fas fa-search"></i> Cari
                </button>
                <a href="{{ route('penduduk.index') }}" class="btn btn-secondary w-100 mt-2">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-table"></i> Daftar Penduduk ({{ $penduduks->total() }} Data)
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penduduks as $p)
                        <tr>
                            <td>{{ ($penduduks->currentPage() - 1) * $penduduks->perPage() + $loop->iteration }}</td>
                            <td>{{ $p->nik }}</td>
                            <td>
                                <strong>{{ $p->nama }}</strong>
                            </td>
                            <td>
                                @if ($p->jenis_kelamin === 'Laki-laki')
                                    <span class="badge bg-primary"><i class="fas fa-mars"></i> Laki-laki</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-venus"></i> Perempuan</span>
                                @endif
                            </td>
                            <td>{{ $p->tanggal_lahir->format('d-m-Y') }} ({{ $p->umur }} thn)</td>
                            <td>{{ Str::limit($p->alamat, 30) }}</td>
                            <td>
                                @if ($p->status_hidup === 'Hidup')
                                    <span class="badge bg-success">Hidup</span>
                                @else
                                    <span class="badge bg-secondary">Mati</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('penduduk.show', $p) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('penduduk.edit', $p) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('penduduk.destroy', $p) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox"></i> Tidak ada data penduduk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($penduduks->hasPages())
            <nav class="d-flex justify-content-center mt-4">
                {{ $penduduks->links('pagination::bootstrap-5') }}
            </nav>
        @endif
    </div>
</div>
@endsection
