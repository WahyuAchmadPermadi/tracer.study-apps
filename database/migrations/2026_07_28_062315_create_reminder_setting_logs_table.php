<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminder_setting_logs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('reminder_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->enum('media', ['email']);

            $table->enum('frequency', [
                'daily',
                'weekly',
                'monthly'
            ]);

            $table->date('start_date')->nullable();

            $table->time('send_time')->nullable();

            $table->string('tahun_lulus')->nullable();

            $table->text('message');

            $table->timestamp('saved_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminder_setting_logs');
    }
};