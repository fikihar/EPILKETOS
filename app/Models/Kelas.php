<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table      = 'tb_kelas';
    protected $primaryKey = 'kd_kelas';

    protected $fillable = ['nm_kelas'];

    /**
     * Kelas memiliki banyak Siswa
     */
    public function siswas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Siswa::class, 'kd_kelas', 'kd_kelas');
    }

    /**
     * Jumlah siswa di kelas ini
     */
    public function jumlahSiswa(): int
    {
        return $this->siswas()->count();
    }
}
