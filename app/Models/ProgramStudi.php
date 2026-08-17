<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $fillable = [
        'kode_program_studi',
        'nama_program_studi',
        'status',
    ];

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', 'Aktif');
    }
}
