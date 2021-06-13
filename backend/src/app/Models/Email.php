<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'from_email',
        'from_name',
        'status',
        'body',
        'subject',
        'content_type',
        'to',
        'cc',
        'bcc',
    ];

    protected $casts = [
        'to' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
    ];

    public const QUEUED_STATUS = 0;
    public const BOUNCED_STATUS = 1;
    public const DELIVERED_STATUS = 2;

    public const STATUSES = [
        self::QUEUED_STATUS => 'Queued',
        self::BOUNCED_STATUS => 'Bounced',
        self::DELIVERED_STATUS => 'Delivered',
    ];

    public function getStatusAsStringAttribute()
    {
        return self::STATUSES[$this->getAttribute('status')];
    }
}
