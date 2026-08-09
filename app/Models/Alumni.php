<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JawabanTracer;

class Alumni extends Model
{
    public const PROGRAM_STUDIS = [
        '54201' => 'Agribisnis',
        '54211' => 'Agroteknologi',
        '54242' => 'Manajemen Sumber Daya Perairan',
        '54244' => 'Teknologi Hasil Perikanan',
        '57201' => 'Sistem Informasi',
        '61201' => 'Manajemen',
        '84202' => 'Pendidikan Matematika',
        '86206' => 'Pendidikan Guru Sekolah Dasar',
        '88203' => 'Pendidikan Bahasa Inggris',
        '352045' => 'Teknik Lingkungan',
    ];

    protected $table = 'alumnis';

    protected $primaryKey = 'nim';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama',
        'tanggal_lahir',
        'kode_program_studi',
        'program_studi',
        'tahun_lulus',
        'email',
        'no_hp',
    ];

    /**
     * Relasi ke jawaban tracer study
     */
    public function jawabanTracer()
    {
        return $this->hasOne(JawabanTracer::class, 'nim', 'nim');
    }

    public static function kodeProgramStudiDariNama(?string $programStudi): ?string
    {
        $programStudi = trim((string) $programStudi);

        foreach (self::PROGRAM_STUDIS as $kode => $nama) {
            if ($programStudi === $nama || $programStudi === "{$kode} - {$nama}") {
                return $kode;
            }
        }

        return null;
    }

    /**
     * Menghasilkan pasangan kode dan nama prodi resmi dari data form/import.
     *
     * @return array{kode_program_studi: string, program_studi: string}
     */
    public static function resolveProgramStudi($kodeProgramStudi, $programStudi = null): array
    {
        $kodeProgramStudi = trim((string) $kodeProgramStudi);
        $programStudi = trim((string) $programStudi);

        if ($kodeProgramStudi !== '') {
            if (!array_key_exists($kodeProgramStudi, self::PROGRAM_STUDIS)) {
                throw new \InvalidArgumentException('Kode program studi tidak terdaftar.');
            }

            $namaResmi = self::PROGRAM_STUDIS[$kodeProgramStudi];

            if ($programStudi !== ''
                && $programStudi !== $namaResmi
                && $programStudi !== "{$kodeProgramStudi} - {$namaResmi}") {
                throw new \InvalidArgumentException('Kode dan nama program studi tidak sesuai.');
            }

            return [
                'kode_program_studi' => $kodeProgramStudi,
                'program_studi' => $namaResmi,
            ];
        }

        $kodeDariNama = self::kodeProgramStudiDariNama($programStudi);

        if (!$kodeDariNama) {
            throw new \InvalidArgumentException('Program studi tidak terdaftar.');
        }

        return [
            'kode_program_studi' => $kodeDariNama,
            'program_studi' => self::PROGRAM_STUDIS[$kodeDariNama],
        ];
    }
}
