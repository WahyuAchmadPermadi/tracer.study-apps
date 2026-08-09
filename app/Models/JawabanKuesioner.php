<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanTracer extends Model
{
    protected $table = 'jawaban_tracer';

    protected $primaryKey = 'id_jawaban';

    public $timestamps = false;

    protected $fillable = [
        'nim',
        'whatsapp',
        'nik',
        'npwp',
        'status',
        'mulai_mencari_kerja',
        'pekerjaan_pertama',
        'pendapatan',
        'jenis_perusahaan',
        'nama_perusahaan',
        'jabatan',
        'provinsi',
        'kabupaten',
        'tingkat_tempat_kerja',
        'studi_lanjut',
        'sumber_biaya',
        'nama_pt',
        'program_studi_lanjut',
        'tanggal_masuk',
        'hubungan_bidang',
        'tingkat_pendidikan',
        'etika_lulus',
        'etika_kerja',
    ];

    public function alumni()
    {
        return $this->belongsTo(
            Alumni::class,
            'nim',
            'nim'
        );
    }
}