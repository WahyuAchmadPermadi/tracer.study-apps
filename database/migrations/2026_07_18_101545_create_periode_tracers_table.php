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
        Schema::create('periode_tracers', function (Blueprint $table) {
            $table->id('id_periode');
            $table->year('tahun');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['Aktif','Selesai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_tracers');
    }
};
