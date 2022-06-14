<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInterest extends BaseModel
{
    use HasFactory;

    protected $table = 'user_interests';
    public $timestamps = false;

    protected $fillable = [
        'interest_id',
        'user_id',
    ];
}
