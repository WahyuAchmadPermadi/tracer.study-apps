<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderSettingLog extends Model
{
    protected $fillable = [
        'reminder_id',
        'media',
        'frequency',
        'start_date',
        'send_time',
        'tahun_lulus',
        'message',
        'saved_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'saved_at' => 'datetime',
    ];

    public function reminder()
    {
        return $this->belongsTo(Reminder::class);
    }
}