<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Role;

interface RoleServiceInterface
{
    public function delete(Role $role):Role;
}
