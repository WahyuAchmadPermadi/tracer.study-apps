<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jawaban_tracer', function (Blueprint $table) {
            $table->unsignedBigInteger('id_periode')->nullable()->after('nim');
            $table->foreign('id_periode')->references('id_periode')->on('periode_tracers')->nullOnDelete();
            $table->dropUnique('jawaban_tracer_nim_unique');
            $table->unique(['nim', 'id_periode'], 'jawaban_tracer_nim_periode_unique');
        });

        Schema::table('reminders', function (Blueprint $table) {
            $table->unsignedBigInteger('id_periode')->nullable()->after('tahun_lulus');
            $table->foreign('id_periode')->references('id_periode')->on('periode_tracers')->nullOnDelete();
        });

        Schema::table('reminder_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('id_periode')->nullable()->after('reminder_id');
            $table->foreign('id_periode')->references('id_periode')->on('periode_tracers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('reminder_logs', function (Blueprint $table) {
            $table->dropForeign(['id_periode']);
            $table->dropColumn('id_periode');
        });

        Schema::table('reminders', function (Blueprint $table) {
            $table->dropForeign(['id_periode']);
            $table->dropColumn('id_periode');
        });

        Schema::table('jawaban_tracer', function (Blueprint $table) {
            $table->dropUnique('jawaban_tracer_nim_periode_unique');
            $table->unique('nim');
            $table->dropForeign(['id_periode']);
            $table->dropColumn('id_periode');
        });
    }
};
