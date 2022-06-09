<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserPost extends BaseModel
{
    protected $fillable = [
        'description',
        'hashtags',
        'title',
        'user_id',
        'post_visibility_id',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function visibility(): HasOne
    {
        return $this->hasOne(UserPostVisibility::class, 'id', 'post_visibility_id');
    }

    public function media(): HasManyThrough
    {
        return $this->hasManyThrough(UserMedia::class, UserPostMedia::class, 'post_id', 'id', 'id', 'media_id');
    }
}
