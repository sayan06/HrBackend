<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserPostMedia extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'media_id',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(UserPost::class, 'post_id', 'id');
    }

    public function media(): HasOne
    {
        return $this->hasOne(UserMedia::class, 'id', 'media_id');
    }
}
