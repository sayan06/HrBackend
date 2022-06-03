<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInformation extends BaseModel
{
    use HasFactory;

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    public const SORTABLE = [];

    public const FILTERABLES = [];

    protected $dateFormat = 'U';

    protected $casts = [];

    protected $fillable = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
