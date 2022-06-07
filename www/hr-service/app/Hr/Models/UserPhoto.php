<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPhoto extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'is_default',
        'is_enabled',
        'name',
        'path',
        'type',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
