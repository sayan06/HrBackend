<?php

namespace App\Hr\Models;

class UserPostVisibility extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];
}
