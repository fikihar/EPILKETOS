<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPilketos extends Model
{
    protected $table = 'tb_datapilketos';

    protected $fillable = [
        'tapel',
        'tgl',
    ];
}
