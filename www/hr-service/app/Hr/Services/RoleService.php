<?php

namespace App\Hr\Services;

use App\Hr\Models\Role;
use App\Hr\Models\User;
use App\Hr\Services\Contracts\RoleServiceInterface;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

final class RoleService implements RoleServiceInterface
{
    public function delete(Role $role): Role
    {
        $assisgnedRoleIdCount = User::role($role->name)->count();

        if ($assisgnedRoleIdCount > 0) {
            throw new BadRequestException('There are users assigned to this role.');
        }

        try {
            DB::beginTransaction();

            $role->permissions()->delete();
            $role->delete();

            DB::commit();

            return $role;
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
