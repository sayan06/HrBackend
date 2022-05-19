<?php

namespace App\Hr\Services;

use App\Hr\Models\User as ModelsUser;
use App\Hr\Models\Role;
use App\Hr\Repositories\Contracts\UserRepositoryInterface;
use App\Hr\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Throwable;

final class UserService implements UserServiceInterface
{
    private $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
    ) {
        $this->userRepo = $userRepo;
    }

    public function createUser(array $attributes): ModelsUser
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepo->createOne($attributes);
            $roleId = data_get($attributes, 'role_id');

            if (empty($roleId)) {
                $roleId = Role::where('name', Role::ROLE_NAME_GUEST)->pluck('id')->first();
            }

            $this->assignRole($user, Role::find($roleId));

            DB::commit();

            return $user;
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function assignRole(User $user, Role $role): User
    {
        $user->syncRoles($role->name);

        return $user;
    }

    public function createAuthToken(User $user): string
    {
        return $user->createToken('roles', $user->roles->pluck('name')->toArray())->plainTextToken;
    }

    public function refreshAuthToken(User $user): string
    {
        $user->tokens()->delete();

        return $this->createAuthToken($user);
    }
}
