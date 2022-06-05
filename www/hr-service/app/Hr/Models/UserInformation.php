<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function interests(): HasMany
    {
        return $this->hasMany(Interest::class, 'interest_id', 'id');
    }

    public function hairColor(): HasOne
    {
        return $this->hasOne(HairColor::class, 'hair_color_id', 'id');
    }

    public function eyeColor(): HasOne
    {
        return $this->hasOne(EyeColor::class, 'eye_color_id', 'id');
    }

    public function religion(): HasOne
    {
        return $this->hasOne(Religion::class, 'religion_id', 'id');
    }

    public function ethnicity(): HasOne
    {
        return $this->hasOne(Ethnicity::class, 'ethnicity_id', 'id');
    }

    public function astrology(): HasOne
    {
        return $this->hasOne(Astrological::class, 'astro_sign_id', 'id');
    }

    public function martialStatus(): HasOne
    {
        return $this->hasOne(MartialStatus::class, 'martial_status_id', 'id');
    }

    public function degree(): HasOne
    {
        return $this->hasOne(Degree::class, 'degree_id', 'id');
    }

    public function bodyStyle(): HasOne
    {
        return $this->hasOne(BodyStyle::class, 'body_style_id', 'id');
    }

    public function alcoholConsumptionTypes(): HasOne
    {
        return $this->hasOne(ConsumptionType::class, 'consumption_type_id', 'id');
    }
}
