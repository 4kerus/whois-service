<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tld extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tld',
        'whois_server',
        'last_checked_at',
    ];

    protected $casts = [
        'last_checked_at' => 'datetime',
    ];
}
