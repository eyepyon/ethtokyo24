<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket_images';

    protected $fillable = [
        'facility_id',
        'path',
        'url',
        'command',
        'month',
    ];

}
