<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jawaban_tracer', function (Blueprint $table) {

            $table->id('id_jawaban');

            // Relasi ke tabel alumnis (PK = nim)
            $table->string('nim', 20);

            $table->foreign('nim')
                ->references('nim')
                ->on('alumnis')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | IDENTITAS
            |--------------------------------------------------------------------------
            */

            $table->string('whatsapp', 20);
            $table->string('nik',16)->nullable();
            $table->string('npwp')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS ALUMNI
            |--------------------------------------------------------------------------
            */

            $table->string('status')->nullable();

            $table->string('mulai_mencari_kerja', 7)->nullable();   // contoh: 2026-01
            $table->string('pekerjaan_pertama', 7)->nullable();     // contoh: 2026-06

            $table->bigInteger('pendapatan')->nullable();

            /*
            |--------------------------------------------------------------------------
            | PEKERJAAN
            |--------------------------------------------------------------------------
            */

            $table->string('jenis_perusahaan')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('tingkat_tempat_kerja')->nullable();

            /*
            |--------------------------------------------------------------------------
            | STUDI LANJUT
            |--------------------------------------------------------------------------
            */

            $table->string('studi_lanjut')->nullable();
            $table->string('sumber_biaya')->nullable();
            $table->string('nama_pt')->nullable();
            $table->string('program_studi_lanjut')->nullable();
            $table->date('tanggal_masuk')->nullable();

            /*
            |--------------------------------------------------------------------------
            | KESESUAIAN PENDIDIKAN
            |--------------------------------------------------------------------------
            */

            $table->string('hubungan_bidang')->nullable();
            $table->string('tingkat_pendidikan')->nullable();

            /*
            |--------------------------------------------------------------------------
            | KOMPETENSI
            |--------------------------------------------------------------------------
            */

            $table->tinyInteger('etika_lulus')->nullable();
            $table->tinyInteger('etika_kerja')->nullable();

            $table->tinyInteger('keahlian_bidang_lulus')->nullable();
            $table->tinyInteger('keahlian_bidang_kerja')->nullable();

            $table->tinyInteger('bahasa_inggris_lulus')->nullable();
            $table->tinyInteger('bahasa_inggris_kerja')->nullable();

            $table->tinyInteger('teknologi_informasi_lulus')->nullable();
            $table->tinyInteger('teknologi_informasi_kerja')->nullable();

            $table->tinyInteger('komunikasi_lulus')->nullable();
            $table->tinyInteger('komunikasi_kerja')->nullable();

            $table->tinyInteger('kerjasama_tim_lulus')->nullable();
            $table->tinyInteger('kerjasama_tim_kerja')->nullable();

            $table->tinyInteger('pengembangan_diri_lulus')->nullable();
            $table->tinyInteger('pengembangan_diri_kerja')->nullable();

            /*
            |--------------------------------------------------------------------------
            | METODE PEMBELAJARAN
            |--------------------------------------------------------------------------
            */

            $table->tinyInteger('perkuliahan')->nullable();
            $table->tinyInteger('demonstrasi')->nullable();
            $table->tinyInteger('proyek_riset')->nullable();
            $table->tinyInteger('magang')->nullable();
            $table->tinyInteger('praktikum')->nullable();
            $table->tinyInteger('kerja_lapangan')->nullable();
            $table->tinyInteger('diskusi')->nullable();

            /*
            |--------------------------------------------------------------------------
            | PENCARIAN KERJA
            |--------------------------------------------------------------------------
            */

            $table->json('cara_mencari')->nullable();

            $table->integer('jumlah_lamaran')->nullable();
            $table->integer('jumlah_respon')->nullable();
            $table->integer('jumlah_wawancara')->nullable();

            $table->string('aktif_mencari')->nullable();
            $table->text('alasan')->nullable();

            /*
            |--------------------------------------------------------------------------
            | SUBMIT
            |--------------------------------------------------------------------------
            */

            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();

            $table->unique('nim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_tracer');
    }
};