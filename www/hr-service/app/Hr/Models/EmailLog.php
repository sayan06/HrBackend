<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailLog extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'body',
        'cc',
        'notification_id',
        'recipient_email',
        'sender_email',
        'subject',
        'time_sent',
    ];

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}
