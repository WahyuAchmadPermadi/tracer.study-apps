<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeTracer extends Model
{
    protected $table = 'periode_tracers';

    protected $primaryKey = 'id_periode';

    protected $fillable = [
        'tahun',
        'tanggal_mulai',
        'tanggal_selesai',
        'status'
    ];

    public function jawabans()
    {
        return $this->hasMany(Jawaban::class, 'id_periode', 'id_periode');
    }

    public function jawabanTracers()
    {
        return $this->hasMany(JawabanTracer::class, 'id_periode', 'id_periode');
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'id_periode', 'id_periode');
    }
}
