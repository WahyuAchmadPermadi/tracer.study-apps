<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminders', function (Blueprint $table) {

            $table->id();

            $table->boolean('is_active')->default(false);

            $table->enum('media', [
                'email',
                'whatsapp'
            ])->default('email');

            $table->enum('frequency', [
                'daily',
                'weekly',
                'monthly'
            ])->default('weekly');

            $table->time('send_time')->default('08:00:00');

            $table->text('message');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};