<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordReset extends BaseModel
{
    const TOKEN_LENGTH = 32;
    const TOKEN_EXPIRATION_SECONDS = 1800;

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'time_requested',
        'token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
