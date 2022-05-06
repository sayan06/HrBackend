<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntityMedia extends BaseModel
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'entity_media';

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }
}
