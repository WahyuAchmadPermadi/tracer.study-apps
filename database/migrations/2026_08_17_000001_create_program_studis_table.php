<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_studis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_program_studi', 20)->unique();
            $table->string('nama_program_studi', 100)->unique();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });

        DB::table('program_studis')->insertOrIgnore([
            ['kode_program_studi' => '54201', 'nama_program_studi' => 'Agribisnis', 'status' => 'Aktif'],
            ['kode_program_studi' => '54211', 'nama_program_studi' => 'Agroteknologi', 'status' => 'Aktif'],
            ['kode_program_studi' => '54242', 'nama_program_studi' => 'Manajemen Sumber Daya Perairan', 'status' => 'Aktif'],
            ['kode_program_studi' => '54244', 'nama_program_studi' => 'Teknologi Hasil Perikanan', 'status' => 'Aktif'],
            ['kode_program_studi' => '57201', 'nama_program_studi' => 'Sistem Informasi', 'status' => 'Aktif'],
            ['kode_program_studi' => '61201', 'nama_program_studi' => 'Manajemen', 'status' => 'Aktif'],
            ['kode_program_studi' => '84202', 'nama_program_studi' => 'Pendidikan Matematika', 'status' => 'Aktif'],
            ['kode_program_studi' => '86206', 'nama_program_studi' => 'Pendidikan Guru Sekolah Dasar', 'status' => 'Aktif'],
            ['kode_program_studi' => '88203', 'nama_program_studi' => 'Pendidikan Bahasa Inggris', 'status' => 'Aktif'],
            ['kode_program_studi' => '352045', 'nama_program_studi' => 'Teknik Lingkungan', 'status' => 'Aktif'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('program_studis');
    }
};
