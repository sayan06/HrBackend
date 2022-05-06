<?php

namespace App\Hr\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    const SORTABLE = [
        'id',
        'name',
    ];
}
