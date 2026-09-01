<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilihan extends Model
{
    protected $table      = 'tb_pilihan';
    protected $primaryKey = 'nisn';
    public    $incrementing = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'nisn',
        'no',
        'nama',
        'photo',
    ];

    /**
     * Calon ini dipilih oleh banyak siswa
     */
    public function pilihans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pilih::class, 'nisn', 'nisn');
    }

    /**
     * Total suara yang diterima calon ini
     */
    public function totalSuara(): int
    {
        return $this->pilihans()->count();
    }

    /**
     * URL foto calon
     */
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/foto-calon/' . $this->photo)
            : asset('img/default-avatar.png');
    }
}
