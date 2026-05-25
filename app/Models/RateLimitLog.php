<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateLimitLog extends Model
{
    protected $table = 'logs_acceso';

    protected $fillable = [
        'ip_address',
        'user_agent',
        'endpoint',
        'payload',
        'status_code',
        'message',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
