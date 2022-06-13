<?php

namespace App\Hr\Models;

class Likability extends BaseModel
{
    public $timestamps = false;

    protected $table = 'likabilities';


    protected $fillable = [
        'user_id',
        'likability',
        'liked_by_id',
    ];
}
