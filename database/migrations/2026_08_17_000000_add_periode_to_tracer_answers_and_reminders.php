<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | JAWABAN TRACER
        |--------------------------------------------------------------------------
        */

        // Tambahkan kolom id_periode jika belum ada.
        if (!Schema::hasColumn('jawaban_tracer', 'id_periode')) {
            Schema::table('jawaban_tracer', function (Blueprint $table) {
                $table->unsignedBigInteger('id_periode')->nullable()->after('nim');
            });
        }

        // Tambahkan foreign key id_periode jika belum ada.
        if (!$this->foreignKeyExists('jawaban_tracer', 'jawaban_tracer_id_periode_foreign')) {
            Schema::table('jawaban_tracer', function (Blueprint $table) {
                $table->foreign('id_periode')
                    ->references('id')
                    ->on('periode_tracers')
                    ->nullOnDelete();
            });
        }

        /*
        |--------------------------------------------------------------------------
        | UBAH UNIQUE NIM MENJADI UNIQUE NIM + PERIODE
        |--------------------------------------------------------------------------
        */

        // Foreign key nim memakai index jawaban_tracer_nim_unique,
        // jadi foreign key harus dilepas terlebih dahulu.
        if ($this->foreignKeyExists('jawaban_tracer', 'jawaban_tracer_nim_foreign')) {
            Schema::table('jawaban_tracer', function (Blueprint $table) {
                $table->dropForeign('jawaban_tracer_nim_foreign');
            });
        }

        // Hapus unique lama pada nim jika masih ada.
        if ($this->indexExists('jawaban_tracer', 'jawaban_tracer_nim_unique')) {
            Schema::table('jawaban_tracer', function (Blueprint $table) {
                $table->dropUnique('jawaban_tracer_nim_unique');
            });
        }

        // Tambahkan unique gabungan nim + id_periode jika belum ada.
        if (!$this->indexExists('jawaban_tracer', 'jawaban_tracer_nim_id_periode_unique')) {
            Schema::table('jawaban_tracer', function (Blueprint $table) {
                $table->unique(
                    ['nim', 'id_periode'],
                    'jawaban_tracer_nim_id_periode_unique'
                );
            });
        }

        // Pasang kembali foreign key nim -> alumnis.nim.
        if (!$this->foreignKeyExists('jawaban_tracer', 'jawaban_tracer_nim_foreign')) {
            Schema::table('jawaban_tracer', function (Blueprint $table) {
                $table->foreign('nim', 'jawaban_tracer_nim_foreign')
                    ->references('nim')
                    ->on('alumnis')
                    ->cascadeOnDelete();
            });
        }

        /*
        |--------------------------------------------------------------------------
        | REMINDERS
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('reminders', 'id_periode')) {
            Schema::table('reminders', function (Blueprint $table) {
                $table->unsignedBigInteger('id_periode')->nullable()->after('tahun_lulus');
            });
        }

        if (
            !$this->foreignKeyExists(
                'reminders',
                'reminders_id_periode_foreign'
            )
        ) {
            Schema::table('reminders', function (Blueprint $table) {
                $table->foreign('id_periode')
                    ->references('id')
                    ->on('periode_tracers')
                    ->nullOnDelete();
            });
        }

        /*
        |--------------------------------------------------------------------------
        | REMINDER LOGS
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('reminder_logs', 'id_periode')) {
            Schema::table('reminder_logs', function (Blueprint $table) {
                $table->unsignedBigInteger('id_periode')->nullable()->after('reminder_id');
            });
        }

        if (
            !$this->foreignKeyExists(
                'reminder_logs',
                'reminder_logs_id_periode_foreign'
            )
        ) {
            Schema::table('reminder_logs', function (Blueprint $table) {
                $table->foreign('id_periode')
                    ->references('id')
                    ->on('periode_tracers')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | REMINDER LOGS
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('reminder_logs', 'id_periode')) {
            if ($this->foreignKeyExists('reminder_logs', 'reminder_logs_id_periode_foreign')) {
                Schema::table('reminder_logs', function (Blueprint $table) {
                    $table->dropForeign('reminder_logs_id_periode_foreign');
                });
            }

            Schema::table('reminder_logs', function (Blueprint $table) {
                $table->dropColumn('id_periode');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | REMINDERS
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('reminders', 'id_periode')) {
            if ($this->foreignKeyExists('reminders', 'reminders_id_periode_foreign')) {
                Schema::table('reminders', function (Blueprint $table) {
                    $table->dropForeign('reminders_id_periode_foreign');
                });
            }

            Schema::table('reminders', function (Blueprint $table) {
                $table->dropColumn('id_periode');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | JAWABAN TRACER
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('jawaban_tracer', 'id_periode')) {
            if ($this->foreignKeyExists('jawaban_tracer', 'jawaban_tracer_id_periode_foreign')) {
                Schema::table('jawaban_tracer', function (Blueprint $table) {
                    $table->dropForeign('jawaban_tracer_id_periode_foreign');
                });
            }

            if ($this->indexExists('jawaban_tracer', 'jawaban_tracer_nim_id_periode_unique')) {
                Schema::table('jawaban_tracer', function (Blueprint $table) {
                    $table->dropUnique('jawaban_tracer_nim_id_periode_unique');
                });
            }

            if (!$this->indexExists('jawaban_tracer', 'jawaban_tracer_nim_unique')) {
                Schema::table('jawaban_tracer', function (Blueprint $table) {
                    $table->unique('nim', 'jawaban_tracer_nim_unique');
                });
            }

            if (!$this->foreignKeyExists('jawaban_tracer', 'jawaban_tracer_nim_foreign')) {
                Schema::table('jawaban_tracer', function (Blueprint $table) {
                    $table->foreign('nim', 'jawaban_tracer_nim_foreign')
                        ->references('nim')
                        ->on('alumnis')
                        ->cascadeOnDelete();
                });
            }

            Schema::table('jawaban_tracer', function (Blueprint $table) {
                $table->dropColumn('id_periode');
            });
        }
    }

    private function foreignKeyExists(string $table, string $constraint): bool
    {
        $database = DB::getDatabaseName();

        return DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('CONSTRAINT_SCHEMA', $database)
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_NAME', $constraint)
            ->exists();
    }

    private function indexExists(string $table, string $index): bool
    {
        $database = DB::getDatabaseName();

        return DB::table('information_schema.STATISTICS')
            ->where('TABLE_SCHEMA', $database)
            ->where('TABLE_NAME', $table)
            ->where('INDEX_NAME', $index)
            ->exists();
    }
};