<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleInfo extends Model
{
    use HasFactory;

    protected $table = 'google_infos';

    protected $fillable = [
        'member_id',
        'access_token',
        'refresh_token',
    ];

}
