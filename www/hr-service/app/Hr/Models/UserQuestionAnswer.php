<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserQuestionAnswer extends BaseModel
{
    use HasFactory;

    protected $table = 'user_responses';
    public $timestamps = false;

    protected $fillable = [
        'question_id',
        'response',
        'user_id',
    ];
}
