<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanTracer extends Model
{
    protected $table = 'jawaban_tracer';

    protected $primaryKey = 'id_jawaban';

    protected $fillable = [
        'nim',
        'id_periode',

        // Identitas
        'whatsapp',
        'nik',
        'npwp',

        // Status Alumni
        'status',
        'mulai_mencari_kerja',
        'pekerjaan_pertama',
        'pendapatan',

        // Pekerjaan
        'jenis_perusahaan',
        'nama_perusahaan',
        'jabatan',
        'provinsi',
        'kabupaten',
        'tingkat_tempat_kerja',

        // Studi Lanjut
        'studi_lanjut',
        'sumber_biaya',
        'nama_pt',
        'program_studi_lanjut',
        'tanggal_masuk',

        // Kesesuaian Pendidikan
        'hubungan_bidang',
        'tingkat_pendidikan',

        // Kompetensi
        'etika_lulus',
        'etika_kerja',

        'keahlian_bidang_lulus',
        'keahlian_bidang_kerja',

        'bahasa_inggris_lulus',
        'bahasa_inggris_kerja',

        'teknologi_informasi_lulus',
        'teknologi_informasi_kerja',

        'komunikasi_lulus',
        'komunikasi_kerja',

        'kerjasama_tim_lulus',
        'kerjasama_tim_kerja',

        'pengembangan_diri_lulus',
        'pengembangan_diri_kerja',

        // Metode Pembelajaran
        'perkuliahan',
        'demonstrasi',
        'proyek_riset',
        'magang',
        'praktikum',
        'kerja_lapangan',
        'diskusi',

        // Pencarian Kerja
        'cara_mencari',
        'jumlah_lamaran',
        'jumlah_respon',
        'jumlah_wawancara',
        'aktif_mencari',
        'alasan',

        // Submit
        'submitted_at',
    ];

    protected $casts = [
        'cara_mencari' => 'array',
        'submitted_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel alumni.
     */
    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'nim', 'nim');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeTracer::class, 'id_periode', 'id_periode');
    }
}
