<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Notification extends BaseModel
{
    const EVENT_TYPE_RESET_PASSWORD = 'reset_password';
    const EVENT_TYPE_RESET_PASSWORD_COMPLETED = 'reset_password_completed';
    const EVENT_TYPE_USER_PASSWORD_UPDATED = 'update_password';

    public $timestamps = false;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'is_processed',
    ];

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_email', 'email');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_email', 'email');
    }

    public function emailLog(): HasOne
    {
        return $this->hasOne(EmailLog::class, 'notification_id');
    }

    public function scopePending($query)
    {
        return $query->where('isProcessed', 0)->where('isSent', 0);
    }

    public function scopeWithin24Hours($query)
    {
        $currentTime = time();
        $past24HourTime = strtotime('-1 day', $currentTime);

        return $query->where('timeToSend', '>=', $past24HourTime)->where('timeToSend', '<=', $currentTime);
    }
}
