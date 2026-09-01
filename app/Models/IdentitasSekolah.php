<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentitasSekolah extends Model
{
    protected $table      = 'tb_identitassekolah';
    protected $primaryKey = 'npsn';
    public    $incrementing = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'npsn',
        'nm_sekolah',
        'logo',
        'jln',
        'desa',
        'kec',
        'kab',
        'kpl_sekolah',
        'nip',
        'ketua_panitia',
        'nip_panitia',
        'waktu_pelaksanaan',
    ];


    public function getLogoUrlAttribute(): string
    {
        return $this->logo
            ? asset("storage/logo/" . $this->logo)
            : asset("img/default-logo.png"); // Fallback statis jika ada
    }

    public function getLogoPathAttribute(): ?string
    {
        // Path fisik khusus untuk DomPDF
        return $this->logo ? storage_path("app/public/logo/" . $this->logo) : null;
    }
}




