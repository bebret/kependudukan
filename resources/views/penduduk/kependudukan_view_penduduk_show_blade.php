@extends('app')

@section('title', 'Detail Penduduk - ' . $penduduk->nama)

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1><i class="fas fa-user"></i> {{ $penduduk->nama }}</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('penduduk.edit', $penduduk) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Kartu Informasi Utama -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-id-card"></i> Data Identitas
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted small">NIK</h6>
                        <p class="fs-5"><strong>{{ $penduduk->nik }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted small">Nama Lengkap</h6>
                        <p class="fs-5"><strong>{{ $penduduk->nama }}</strong></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted small">Jenis Kelamin</h6>
                        <p>
                            @if ($penduduk->jenis_kelamin === 'Laki-laki')
                                <span class="badge bg-primary"><i class="fas fa-mars"></i> Laki-laki</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-venus"></i> Perempuan</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted small">Status Hidup</h6>
                        <p>
                            @if ($penduduk->status_hidup === 'Hidup')
                                <span class="badge bg-success">Hidup</span>
                            @else
                                <span class="badge bg-secondary">Mati</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted small">Tanggal Lahir</h6>
                        <p>{{ $penduduk->tanggal_lahir->format('d F Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted small">Umur</h6>
                        <p><strong>{{ $penduduk->umur }} Tahun</strong></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-muted small">Tempat Lahir</h6>
                        <p>{{ $penduduk->tempat_lahir }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Alamat -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-map-marker-alt"></i> Informasi Alamat
            </div>
            <div class="card-body">
                <h6 class="text-muted small">Alamat Lengkap</h6>
                <p>{{ $penduduk->alamat }}</p>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted small">Kelurahan</h6>
                        <p>{{ $penduduk->kelurahan }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted small">Kecamatan</h6>
                        <p>{{ $penduduk->kecamatan }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <h6 class="text-muted small">Kota/Kabupaten</h6>
                        <p>{{ $penduduk->kota }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted small">Provinsi</h6>
                        <p>{{ $penduduk->provinsi }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted small">Kode Pos</h6>
                        <p>{{ $penduduk->kode_pos ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Informasi Tambahan
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted small">Status Perkawinan</h6>
                        <p><strong>{{ $penduduk->status_perkawinan }}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted small">Agama</h6>
                        <p>{{ $penduduk->agama ?? '-' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted small">Pendidikan</h6>
                        <p>{{ $penduduk->pendidikan ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted small">Pekerjaan</h6>
                        <p>{{ $penduduk->pekerjaan ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Card Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-clipboard"></i> Ringkasan
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-6">Status:</dt>
                    <dd class="col-sm-6">
                        @if ($penduduk->status_hidup === 'Hidup')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Non-Aktif</span>
                        @endif
                    </dd>

                    <dt class="col-sm-6">Catatan:</dt>
                    <dd class="col-sm-6">
                        @switch($penduduk->status_perkawinan)
                            @case('Belum Kawin')
                                <span class="badge bg-info">{{ $penduduk->status_perkawinan }}</span>
                                @break
                            @case('Kawin')
                                <span class="badge bg-success">{{ $penduduk->status_perkawinan }}</span>
                                @break
                            @default
                                <span class="badge bg-warning">{{ $penduduk->status_perkawinan }}</span>
                        @endswitch
                    </dd>
                </dl>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-cogs"></i> Aksi
            </div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('penduduk.edit', $penduduk) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
                <form action="{{ route('penduduk.destroy', $penduduk) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100"
                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                        <i class="fas fa-trash"></i> Hapus Data
                    </button>
                </form>
                <a href="{{ route('penduduk.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-history"></i> Catatan Sistem
            </div>
            <div class="card-body small">
                <p class="mb-2">
                    <strong>Dibuat:</strong><br>
                    {{ $penduduk->created_at->format('d F Y H:i') }}
                </p>
                <p class="mb-0">
                    <strong>Diperbarui:</strong><br>
                    {{ $penduduk->updated_at->format('d F Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
