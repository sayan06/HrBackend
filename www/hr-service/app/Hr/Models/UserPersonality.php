<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPersonality extends BaseModel
{
    use HasFactory;

    protected $table = 'user_personalities';
    public $timestamps = false;

    protected $fillable = [
        'personality_type_id',
        'user_id',
    ];
}
