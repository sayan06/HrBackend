<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ethnicity extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'ethnicities';
}
