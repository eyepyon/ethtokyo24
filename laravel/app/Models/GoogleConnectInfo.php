<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleConnectInfo extends Model
{
    use HasFactory;

    protected $table = 'google_connect_infos';

    protected $fillable = [
        'member_id',
        'session_state_token',
        'room_id',
    ];

}
