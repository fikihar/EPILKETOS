<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Siswa extends Authenticatable
{
    protected $table      = 'tb_siswa';
    protected $primaryKey = 'username';
    public    $incrementing = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'username',
        'password',
        'nm_siswa',
        'jk',
        'kd_kelas',
        'hadir',
    ];

    protected $hidden = ['password', 'remember_token'];

    /**
     * Auto-hash password saat diset lewat mass-assignment
     */
    public function setPasswordAttribute(string $value): void
    {
        // Hanya hash jika belum di-hash
        $this->attributes['password'] = Hash::needsRehash($value)
            ? Hash::make($value)
            : $value;
    }

    // ─── Relasi ───────────────────────────────────────────

    /**
     * Siswa milik satu Kelas
     */
    public function kelas(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kd_kelas', 'kd_kelas');
    }

    /**
     * Siswa memiliki satu record vote
     */
    public function pilih(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Pilih::class, 'username', 'username');
    }

    /**
     * Cek apakah siswa sudah vote
     */
    public function sudahVote(): bool
    {
        return $this->pilih()->exists();
    }
}
