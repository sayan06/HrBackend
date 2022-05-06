<?php

namespace App\Hr\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public const ROLE_NAME_GUEST = 'guest';

    const SORTABLE = [
        'id',
        'name',
    ];

    public const FILTERABLES = [
        'id',
        'name',
    ];

    protected $fillable = [
        'name',
        'guard_name'
    ];

    public function isGuest(): bool
    {
        return $this->name === self::ROLE_NAME_GUEST;
    }
}
