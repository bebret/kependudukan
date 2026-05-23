<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penduduk extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'status_perkawinan',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_hidup',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relation: Keluarga (satu penduduk bisa jadi kepala keluarga)
     */
    public function keluargaAsKepala()
    {
        return $this->hasMany(Keluarga::class, 'kepala_keluarga_id');
    }

    /**
     * Relation: Hubungan Keluarga (anggota keluarga)
     */
    public function hubunganKeluarga()
    {
        return $this->hasMany(HubunganKeluarga::class, 'penduduk_id');
    }

    /**
     * Relation: Keluarga yang diikuti
     */
    public function keluargas()
    {
        return $this->belongsToMany(Keluarga::class, 'hubungan_keluargas', 'penduduk_id', 'keluarga_id')
                    ->withPivot('hubungan', 'masih_tinggal_bersama')
                    ->withTimestamps();
    }

    /**
     * Accessor: Hitung umur dari tanggal lahir
     */
    public function getUmurAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
    }

    /**
     * Scope: Filter penduduk hidup
     */
    public function scopeHidup($query)
    {
        return $query->where('status_hidup', 'Hidup');
    }

    /**
     * Scope: Filter berdasarkan nama
     */
    public function scopeByNama($query, $nama)
    {
        return $query->where('nama', 'LIKE', "%{$nama}%");
    }

    /**
     * Scope: Filter berdasarkan NIK
     */
    public function scopeByNik($query, $nik)
    {
        return $query->where('nik', $nik);
    }

    /**
     * Scope: Filter berdasarkan jenis kelamin
     */
    public function scopeByJenisKelamin($query, $jenis_kelamin)
    {
        return $query->where('jenis_kelamin', $jenis_kelamin);
    }
}
