<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [

        'is_active',
        'media',
        'frequency',
        'send_time',
        'start_date',
        'tahun_lulus',
        'message',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
    ];

    public function settingLogs()
    {
        return $this->hasMany(ReminderSettingLog::class);
    }
}
