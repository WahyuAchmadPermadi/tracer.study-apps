<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawabans';

    protected $primaryKey = 'id_jawaban';

    protected $fillable = [
        'nim',
        'id_periode',
        'id_kuesioner',
        'jawaban'
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'nim', 'nim');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeTracer::class, 'id_periode', 'id_periode');
    }

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class, 'id_kuesioner', 'id_kuesioner');
    }
}