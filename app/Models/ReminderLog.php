<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderLog extends Model
{
    protected $fillable = [
        'reminder_id',
        'id_periode',
        'nim',
        'nama_alumni',
        'media',
        'source',
        'status',
        'message',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'nim', 'nim');
    }

    public function reminder()
    {
        return $this->belongsTo(Reminder::class);
    }
}
