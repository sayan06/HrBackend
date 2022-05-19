<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\Role;
use App\Hr\Models\User;
use App\Hr\Repositories\Contracts\UserRepositoryInterface;
use App\Hr\Resources\UserResource;
use App\Hr\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class UserController extends ApiController
{
    private const RULE_INT_MIN_1 = 'int|min:1';

    private $userService;
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserServiceInterface $userService,
    ) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function getUsers(Request $request)
    {
        $request->validate([
            'limit' => self::RULE_INT_MIN_1,
            'page' => self::RULE_INT_MIN_1,
        ]);

        $sortColumn = $request->input('col', 'id');
        $sortOrder = $request->input('order', 'desc');
        $pageLimit = $request->input('limit', config('hr.default_page_size'));

        $sortableDto = new SortableDto($sortColumn, $sortOrder, User::class);

        $userCollection = $this->userRepository->getMany($sortableDto, $pageLimit);

        return $this->respondPaginated(UserResource::collection($userCollection));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'disabled' => ['bool'],
            'email' => ['bail', 'email', 'filled', 'max:50', 'nullable', 'unique:users,email,' . $user->id],
            'name' => ['string', 'max:50', 'filled', 'nullable'],
            'password' => ['bail', 'string', 'filled', 'min:6', 'max:30', 'nullable'],
            'confirm_password' => ['bail', 'string', 'filled', 'min:6', 'max:30', 'nullable', 'same:password'],
            'phone' => ['string', 'filled', 'min:10', 'max:30', 'nullable'],
            'role_id' => ['bail', 'integer', 'exists:roles,id', 'nullable'],
            'title' => ['bail', 'string', 'filled', 'max:30', 'nullable'],
        ]);

        $authUser =  $request->user();

        if ($request->user()->roles->first()->name === Role::ROLE_NAME_GUEST) {
            throw new BadRequestException('Guest are not allowed to update their profile.');
        }

        if (!empty($request->role_id)) {
            $role = Role::findOrFail($request->role_id);

            if ($role->isGuest()) {
                throw new BadRequestException('Guest role cannot be assigned');
           }
        }

        $isSuperAdmin = $authUser->hasRole('super_admin');

        if ($user->email === $authUser->email) {
            if ($request->has('disabled')) {
                $message = $isSuperAdmin
                    ? 'SuperAdmins cannot deactivate themselves.'
                    : 'Can not activate or deactivate user.';

                    return $this->respondForbidden($message);
            }

            if ($request->has('role_id') && $isSuperAdmin) {
                return $this->respondForbidden('SuperAdmins cannot change their roles.');
            }

            if (!$isSuperAdmin) {
                if (!empty($request->password) || !empty($request->email) || !empty($request->role_id)) {
                    throw new BadRequestException('Can not update email, password and role_id field of user.');
                }
                $userDetails = [
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'title' => $request->input('title'),
                ];

                return $this->respondSuccess(
                    'User updated successfully.',
                    new UserResource($this->userRepository->updateOne($user, $userDetails))
                );
            }
        }

        if ($isSuperAdmin) {
            $user->tokens()->delete();

            if ($request->has('role_id')) {
                $role = Role::find($request->input('role_id'));
                $this->userService->assignRole($user, $role);
            }

            return $this->respondSuccess(
                'User updated successfully.',
                new UserResource($this->userRepository->updateOne($user, $request->all()))
            );
        }

        $this->respondForbidden('Unauthorized.');
    }

    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'old_password' => ['bail', 'required','string', 'filled', 'min:6', 'max:30', 'nullable'],
            'new_password' => ['bail', 'required', 'string', 'filled', 'min:6', 'max:30', 'nullable'],
        ]);

        $authUser =  $request->user();

        if ($request->user()->roles->first()->name === Role::ROLE_NAME_GUEST) {
            throw new BadRequestException('Guest are not allowed to change their password.');
        }

        if (!Hash::check($request->old_password, $user->password)) {
            throw new BadRequestException('Wrong password.');
        }

        if ($request->old_password === $request->new_password) {
            throw new BadRequestException('New password should not match the old one.');
        }

        if ($user->email !== $authUser->email) {
            return $this->respondForbidden('Only a logged in user can change his own password.');
        }

        $user->update(['password' => bcrypt($request->new_password)]);
        $request->user()->tokens()->delete();

        return $this->respondSuccess(
            'Password updated successfully.',
            new UserResource($user)
        );
    }

    public function getUser(User $user)
    {
        return new UserResource($user);
    }
}
