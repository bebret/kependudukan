<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keluarga extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomor_keluarga',
        'kepala_keluarga_id',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relation: Kepala Keluarga
     */
    public function kepalKeluarga()
    {
        return $this->belongsTo(Penduduk::class, 'kepala_keluarga_id');
    }

    /**
     * Relation: Anggota Keluarga
     */
    public function anggota()
    {
        return $this->hasMany(HubunganKeluarga::class, 'keluarga_id');
    }

    /**
     * Relation: Penduduk (Many-to-Many)
     */
    public function penduduks()
    {
        return $this->belongsToMany(Penduduk::class, 'hubungan_keluargas', 'keluarga_id', 'penduduk_id')
                    ->withPivot('hubungan', 'masih_tinggal_bersama')
                    ->withTimestamps();
    }

    /**
     * Get jumlah anggota keluarga
     */
    public function getJumlahAnggotaAttribute()
    {
        return $this->anggota()->count();
    }
}
