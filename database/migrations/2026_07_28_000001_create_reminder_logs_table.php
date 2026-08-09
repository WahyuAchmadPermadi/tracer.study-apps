<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminder_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_id')->nullable()->constrained('reminders')->nullOnDelete();
            $table->string('nim', 20);
            $table->string('nama_alumni', 100);
            $table->string('media', 20);
            $table->enum('source', ['manual', 'scheduled'])->default('manual');
            $table->enum('status', ['sent', 'failed']);
            $table->text('message');
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['source', 'sent_at']);
            $table->index(['status', 'sent_at']);
            $table->index('nim');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminder_logs');
    }
};
