<?php

namespace App\Hr\Controllers\api\v1;

use App\Exceptions\BusinessRuleViolationException;
use App\Hr\Controllers\api\ApiController;
use App\Hr\Services\Contracts\PasswordResetServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

final class PasswordResetController extends ApiController
{
    private PasswordResetServiceInterface $passwordResetService;

    public function __construct(
        PasswordResetServiceInterface $passwordResetService
    ) {
        $this->passwordResetService = $passwordResetService;
    }

    public function sendPasswordResetMail(Request $request)
    {
        $request->validate([
            'find' => 'required|string',
        ]);

        $find = $request->input('find');

        try {
            $user = $this->passwordResetService->findUser($find);

            return $this->setStatusCode(200)->respond([
                'data' => [
                    'user_id' => $user->id,
                    'password_reset' => $this->passwordResetService->sendResetEmail($user),
                ],
            ]);
        } catch (ModelNotFoundException $ex) {
            Log::error('Password reset validation error: No user found.', compact('find'));

            return $this->respondNotFound($ex->getMessage());
        } catch (BusinessRuleViolationException) {
            Log::error('Password reset validation error: Multiple users found.', compact('find'));

            return $this->setStatusCode(400)->respond([
                'data' => [
                    'multiple_users' => true,
                ],
            ]);
        }
    }

    public function resetPasswordByToken(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'token' => 'required|string|size:32',
        ]);

        try {
            $password = $request->input('password');
            $token = $request->input('token');
            $this->passwordResetService->resetPasswordByToken($token, $password);

            $user = $this->passwordResetService->getUser();

            return $this->setStatusCode(200)->respond([
                'user' => $user,
            ]);
        } catch (NotFoundResourceException) {
            return $this->respondNotFound('Invalid token.');
        } catch (BadRequestException|ValidationException $ex) {
            return $this->respondBadRequest($ex->getMessage());
        }
    }
}
