<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserIdealMatch extends BaseModel
{
    use HasFactory;

    protected $table = 'user_ideal_matches';
    public $timestamps = false;

    protected $fillable = [
        'ideal_match_id',
        'user_id',
    ];
}
