<?php

namespace App\Hr\Services;

use App\Hr\Models\Likability;
use App\Hr\Models\Role;
use App\Hr\Models\User;
use App\Hr\Repositories\Contracts\UserRepositoryInterface;
use App\Hr\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

final class UserService implements UserServiceInterface
{
    private $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
    ) {
        $this->userRepo = $userRepo;
    }

    public function createUser(array $attributes): User
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

    public function createUserDetails(User $user, array $attributes = [])
    {
        dd($attributes);
    }

    public function getLikability(User $user, array $attributes = [])
    {
        $likabilityData = [
            'user_id' => data_get($attributes, 'user_id'),
            'likability' => data_get($attributes, 'likability'),
            'liked_by_id' => $user->id,
        ];

        if ($likabilityData['user_id'] === $likabilityData['liked_by_id']) {
            throw new BadRequestException('User can only like or dislike other active users');
        }

        $alreadyLiked = Likability::where('user_id', $likabilityData['user_id'])->where('liked_by_id', $likabilityData['liked_by_id'])->count();

        if ($alreadyLiked >= 1) {
            Likability::where('user_id', $likabilityData['user_id'])->where('liked_by_id', $likabilityData['liked_by_id'])->delete();
        }

        try {
            DB::beginTransaction();

            Likability::create($likabilityData);

            DB::commit();

            return $user->load('likability');
        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }

}
