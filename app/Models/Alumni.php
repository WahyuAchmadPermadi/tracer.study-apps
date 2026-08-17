<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JawabanTracer;

class Alumni extends Model
{
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

    public function jawabanTracers()
    {
        return $this->hasMany(JawabanTracer::class, 'nim', 'nim');
    }

    public static function kodeProgramStudiDariNama(?string $programStudi): ?string
    {
        $programStudi = trim((string) $programStudi);

        return ProgramStudi::query()
            ->where('nama_program_studi', $programStudi)
            ->value('kode_program_studi');
    }

    /**
     * Menormalisasi nomor HP Indonesia ke format E.164 +628xxxxxxxxxx.
     *
     * Format yang dapat diterima untuk import: 08..., 62..., +62..., atau 8....
     *
     * @throws \InvalidArgumentException
     */
    public static function normalizeNoHp(mixed $noHp): string
    {
        if (is_float($noHp)) {
            $noHp = number_format($noHp, 0, '', '');
        }

        $noHp = trim((string) $noHp);

        if (!preg_match('/^\+?\d+$/', $noHp)) {
            throw new \InvalidArgumentException('Nomor HP hanya boleh berisi angka, dengan tanda + hanya di awal nomor.');
        }

        $digits = ltrim($noHp, '+');

        if (str_starts_with($digits, '0')) {
            $digits = substr($digits, 1);
        } elseif (str_starts_with($digits, '62')) {
            $digits = substr($digits, 2);
        }

        if (!preg_match('/^8\d{7,12}$/', $digits)) {
            throw new \InvalidArgumentException('Nomor HP harus merupakan nomor Indonesia yang valid, misalnya 89612345678.');
        }

        return '+62'.$digits;
    }

    /**
     * Menghasilkan nomor untuk field form yang sudah memiliki prefix +62.
     */
    public static function noHpUntukInput(?string $noHp): string
    {
        try {
            return substr(self::normalizeNoHp($noHp), 3);
        } catch (\InvalidArgumentException) {
            return preg_replace('/\D/', '', (string) $noHp) ?? '';
        }
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

        $program = ProgramStudi::aktif()
            ->when($kodeProgramStudi !== '', fn ($query) => $query->where('kode_program_studi', $kodeProgramStudi))
            ->when($kodeProgramStudi === '', fn ($query) => $query->where('nama_program_studi', $programStudi))
            ->first();

        if (!$program || ($programStudi !== '' && $programStudi !== $program->nama_program_studi && $programStudi !== "{$program->kode_program_studi} - {$program->nama_program_studi}")) {
            throw new \InvalidArgumentException('Program studi tidak terdaftar atau tidak aktif.');
        }

        return [
            'kode_program_studi' => $program->kode_program_studi,
            'program_studi' => $program->nama_program_studi,
        ];
    }
}
