<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilih extends Model
{
    protected $table      = 'tb_pilih';
    protected $primaryKey = 'id_pilih';

    protected $fillable = [
        'nisn',     // ID calon (Pilihan)
        'username', // ID pemilih (Siswa)
    ];

    /**
     * Pilihan yang dipilih (Relasi ke Calon)
     */
    public function pilihan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pilihan::class, 'nisn', 'nisn');
    }

    /**
     * Siswa yang melakukan pemilihan
     */
    public function siswa(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'username', 'username');
    }
}
