<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->string('kode_program_studi', 6)->nullable()->after('program_studi');
        });

        $programStudis = [
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

        foreach ($programStudis as $kode => $nama) {
            DB::table('alumnis')
                ->where('program_studi', $nama)
                ->orWhere('program_studi', "{$kode} - {$nama}")
                ->update(['kode_program_studi' => $kode]);
        }
    }

    public function down(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->dropColumn('kode_program_studi');
        });
    }
};
