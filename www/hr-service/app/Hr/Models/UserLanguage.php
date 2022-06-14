<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLanguage extends BaseModel
{
    use HasFactory;

    protected $table = 'user_languages';
    public $timestamps = false;

    protected $fillable = [
        'language_id',
        'user_id',
    ];
}
