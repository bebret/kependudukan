@extends('app')

@section('title', 'Edit Data Penduduk - SIPENDUK')

@push('styles')
<style>
    /* Styling Form Dark Mode - Konsisten dengan Create */
    .form-label-custom {
        color: var(--text-muted);
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-dark {
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        padding: 10px 15px;
        border-radius: 8px;
    }

    .form-control-dark:focus {
        background-color: rgba(0, 0, 0, 0.3);
        border-color: var(--accent-blue);
        color: var(--text-main);
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    .form-control-dark:disabled {
        background-color: rgba(255, 255, 255, 0.05);
        color: var(--text-muted);
        cursor: not-allowed;
    }

    .form-select-dark {
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        padding: 10px 15px;
        border-radius: 8px;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }

    .form-select-dark:focus {
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    .form-select-dark option {
        background-color: var(--bg-sidebar);
    }

    .text-danger-custom {
        color: var(--danger-color);
        margin-left: 3px;
    }

    .btn-footer {
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>
@endpush

@section('content')

<div class="top-header">
    <div>
        <h1><i class="fas fa-user-edit me-2 text-warning"></i> Edit Data Penduduk</h1>
        <p>Memperbarui informasi penduduk: <strong>{{ $penduduk->nama }}</strong></p>
    </div>
</div>

<div class="px-4 pb-5">
    <form action="{{ route('penduduk.update', $penduduk->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="card-custom mb-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label-custom">NIK (16 Digit)<span class="text-danger-custom">*</span></label>
                        <input type="text" name="nik" class="form-control form-control-dark @error('nik') is-invalid @enderror" maxlength="16" value="{{ old('nik', $penduduk->nik) }}" required>
                        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Jenis Kelamin<span class="text-danger-custom">*</span></label>
                        <select name="jenis_kelamin" class="form-select form-select-dark @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Tempat Lahir<span class="text-danger-custom">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control form-control-dark @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" required>
                        @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label-custom">Nama Lengkap<span class="text-danger-custom">*</span></label>
                        <input type="text" name="nama" class="form-control form-control-dark @error('nama') is-invalid @enderror" value="{{ old('nama', $penduduk->nama) }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Tanggal Lahir<span class="text-danger-custom">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control form-control-dark @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir) }}" required>
                        @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Agama<span class="text-danger-custom">*</span></label>
                        <select name="agama" class="form-select form-select-dark @error('agama') is-invalid @enderror" required>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama', $penduduk->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label-custom">Alamat Lengkap<span class="text-danger-custom">*</span></label>
                        <textarea name="alamat" class="form-control form-control-dark @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $penduduk->alamat) }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Kelurahan</label>
                    <input type="text" name="kelurahan" class="form-control form-control-dark" value="{{ old('kelurahan', $penduduk->kelurahan) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control form-control-dark" value="{{ old('kecamatan', $penduduk->kecamatan) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Kota/Kabupaten</label>
                    <input type="text" name="kota" class="form-control form-control-dark" value="{{ old('kota', $penduduk->kota) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control form-control-dark" value="{{ old('provinsi', $penduduk->provinsi) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Kode Pos</label>
                    <input type="text" name="kode_pos" class="form-control form-control-dark @error('kode_pos') is-invalid @enderror" 
                        maxlength="5" placeholder="Contoh: 40123" 
                        value="{{ old('kode_pos', $penduduk->kode_pos ?? '') }}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('kode_pos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label-custom">Status Perkawinan</label>
                    <select name="status_perkawinan" class="form-select form-select-dark">
                        @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                            <option value="{{ $status }}" {{ old('status_perkawinan', $penduduk->status_perkawinan) == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Status Hidup</label>
                    <select name="status_hidup" class="form-select form-select-dark">
                        <option value="1" {{ old('status_hidup', $penduduk->status_hidup) == '1' ? 'selected' : '' }}>Hidup</option>
                        <option value="0" {{ old('status_hidup', $penduduk->status_hidup) == '0' ? 'selected' : '' }}>Meninggal</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan" class="form-control form-control-dark" value="{{ old('pendidikan', $penduduk->pendidikan) }}">
                </div>
                <div class="col-12">
                    <label class="form-label-custom">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control form-control-dark" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('penduduk.index') }}" class="btn btn-secondary btn-footer">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="reset" class="btn btn-warning btn-footer text-dark">
                <i class="fas fa-undo"></i> Reset
            </button>
            <button type="submit" class="btn btn-custom-blue btn-footer">
                <i class="fas fa-save"></i> Perbarui Data
            </button>
        </div>
    </form>
</div>

@endsection