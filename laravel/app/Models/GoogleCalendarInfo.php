<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleCalendarInfo extends Model
{
    use HasFactory;

    protected $table = 'google_calendar_infos';

    protected $fillable = [
        'member_id',
        'room_id',
        'event_id',
    ];

}
