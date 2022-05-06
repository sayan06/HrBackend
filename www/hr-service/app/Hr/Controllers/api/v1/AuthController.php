<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\Models\Role;
use App\Hr\Models\User;
use App\Hr\Resources\UserResource;
use App\Hr\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class AuthController extends ApiController
{
    private $userService;

    public function __construct(
        UserServiceInterface $userService,
    ) {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => ['bail', 'required', 'email', 'max:100', 'unique:users,email'],
            'title' => ['bail', 'string', 'filled', 'max:30', 'nullable'],
            'name' => ['string', 'max:50', 'filled', 'nullable', 'required'],
            'password' => ['bail', 'string', 'filled', 'min:6', 'max:30', 'nullable', 'required'],
            'role_id' => ['bail', 'integer', 'exists:roles,id', 'nullable'],
            'phone' => ['string', 'filled', 'min:10', 'max:30', 'nullable'],
        ]);

        if (!empty($request->role_id)) {
            $role = Role::findOrFail($request->role_id);

            if ($role->isGuest()) {
                throw new BadRequestException('Guest role cannot be assigned');
           }
        }

        return $this->respondCreated('User created successfully', [
            'user' => new UserResource($this->userService->createUser($request->all())),
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['bail', 'required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->setStatusCode(401)->respondWithError('Bad email or password.');
        }

        $user = Auth::user();

        if (!$user->isActive()) {
            $user->tokens()->delete();

            return $this->respondForbidden('User is deactivated');
        }

        return $this->respondSuccess('Login success', [
            'user' => new UserResource($user),
            'token' => $this->userService->createAuthToken($user),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->respond('Logout success');
    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'email' => ['bail', 'required', 'email'],
            'password' => ['required'],
        ]);

        $user = $this->findUser($request);

        return $this->respondSuccess('New token created', [
            'user' => new UserResource($user),
            'token' => $this->userService->refreshAuthToken($user),
        ]);
    }

    private function findUser(Request $request): User
    {
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            throw new BadRequestException('Wrong password.');
        }

        return $user;
    }
}
