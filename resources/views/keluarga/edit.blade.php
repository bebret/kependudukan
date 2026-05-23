@extends('app')

@section('title', 'Edit Keluarga - SIPENDUK')

@push('styles')
<style>
    .form-label-custom { color: var(--text-muted); font-size: 0.85rem; font-weight: 500; margin-bottom: 8px; display: block; }
    .form-control-dark, .form-select-dark {
        background-color: rgba(0, 0, 0, 0.2); border: 1px solid var(--border-color); color: var(--text-main); padding: 10px 15px; border-radius: 8px;
    }
    .form-control-dark:focus, .form-select-dark:focus {
        background-color: rgba(0, 0, 0, 0.3); border-color: var(--accent-blue); box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25); color: var(--text-main);
    }
    .form-select-dark {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }
    .form-select-dark option { background-color: var(--bg-sidebar); }
    .text-danger-custom { color: var(--danger-color); margin-left: 3px; }
</style>
@endpush

@section('content')
<div class="top-header">
    <div>
        <h1><i class="fas fa-edit me-2 text-warning"></i> Edit Data Keluarga</h1>
        <p>Memperbarui informasi untuk No. KK: <strong>{{ $keluarga->nomor_keluarga }}</strong></p>
    </div>
</div>

<div class="px-4 pb-5">
    <form action="{{ route('keluarga.update', $keluarga->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="card-custom mb-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label-custom">No. Keluarga (16 digit)<span class="text-danger-custom">*</span></label>
                    <input type="text" name="nomor_keluarga" class="form-control form-control-dark @error('nomor_keluarga') is-invalid @enderror" maxlength="16" value="{{ old('nomor_keluarga', $keluarga->nomor_keluarga) }}" required>
                    @error('nomor_keluarga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Kepala Keluarga<span class="text-danger-custom">*</span></label>
                    <select name="kepala_keluarga_id" class="form-select form-select-dark @error('kepala_keluarga_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kepala Keluarga --</option>
                        @foreach($penduduks as $p)
                            <option value="{{ $p->id }}" {{ old('kepala_keluarga_id', $keluarga->kepala_keluarga_id) == $p->id ? 'selected' : '' }}>{{ $p->nik }} - {{ $p->nama }}</option>
                        @endforeach
                    </select>
                    @error('kepala_keluarga_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label-custom">Alamat Lengkap<span class="text-danger-custom">*</span></label>
                    <textarea name="alamat" class="form-control form-control-dark @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $keluarga->alamat) }}</textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Kelurahan<span class="text-danger-custom">*</span></label>
                    <input type="text" name="kelurahan" class="form-control form-control-dark" value="{{ old('kelurahan', $keluarga->kelurahan) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Kecamatan<span class="text-danger-custom">*</span></label>
                    <input type="text" name="kecamatan" class="form-control form-control-dark" value="{{ old('kecamatan', $keluarga->kecamatan) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Kota/Kabupaten<span class="text-danger-custom">*</span></label>
                    <input type="text" name="kota" class="form-control form-control-dark" value="{{ old('kota', $keluarga->kota) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Provinsi<span class="text-danger-custom">*</span></label>
                    <input type="text" name="provinsi" class="form-control form-control-dark" value="{{ old('provinsi', $keluarga->provinsi) }}" required>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('keluarga.show', $keluarga) }}" class="btn btn-secondary px-4" style="border-radius: 8px;"><i class="fas fa-arrow-left"></i> Kembali</a>
            <button type="submit" class="btn btn-custom-blue px-4" style="border-radius: 8px;"><i class="fas fa-save"></i> Perbarui Data</button>
        </div>
    </form>
</div>
@endsection