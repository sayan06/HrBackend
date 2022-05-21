<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordHistory extends BaseModel
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'hash',
        'created_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
