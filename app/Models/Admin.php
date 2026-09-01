<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    protected $table      = 'tb_admin';
    protected $primaryKey = 'username';
    public    $incrementing = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    /**
     * Auto-hash password saat diset
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
