<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFlavour extends BaseModel
{
    use HasFactory;

    protected $table = 'user_flavours';
    public $timestamps = false;

    protected $fillable = [
        'flavour_id',
        'user_id',
    ];
}
