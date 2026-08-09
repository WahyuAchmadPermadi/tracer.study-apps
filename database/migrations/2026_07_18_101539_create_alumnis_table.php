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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->string('nim',20)->primary();
            $table->string('nama',100);
            $table->date('tanggal_lahir');
            $table->string('program_studi',100);
            $table->year('tahun_lulus');
            $table->string('email')->nullable();
            $table->string('no_hp',20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
