<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Media extends BaseModel
{
    use HasFactory;

    protected $table = 'media_items';
    protected $dateFormat = 'U';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'media_type_id',
    ];

    public function entity(): HasOne
    {
        return $this->hasOne(EntityMedia::class, 'media_id', 'id');
    }
}
