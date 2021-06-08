<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'from_email', 'from_name', 'status',
        'body', 'subject', 'content_type',
        'tos', 'ccs', 'bccs',
    ];

    protected $casts = [
        'tos' => 'array',
        'ccs' => 'array',
        'bccs' => 'array',
    ];

    const STATUSES = [
        0 => 'Queued',
        1 => 'Bounced',
        2 => 'Delivered',

        'Bounced' => 1,
        'Delivered' => 2,
    ];

    public function getStatusAttribute()
    {
        return self::STATUSES[$this->status];
    }
}
