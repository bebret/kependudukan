<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HubunganKeluarga extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'penduduk_id',
        'keluarga_id',
        'hubungan',
        'masih_tinggal_bersama',
    ];

    protected $casts = [
        'masih_tinggal_bersama' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relation: Penduduk
     */
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    /**
     * Relation: Keluarga
     */
    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_id');
    }
}
