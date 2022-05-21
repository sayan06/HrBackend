<?php

namespace App\Hr\Repositories;

use App\Hr\Models\PasswordReset;
use App\Hr\Models\User;
use App\Hr\Repositories\Contracts\PasswordResetRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

class PasswordResetRepository extends BaseRepository implements PasswordResetRepositoryInterface
{
    public function __construct(PasswordReset $model)
    {
        $this->model = $model;
    }

    /**
     * Create a standard forgot password reset token for specified user.
     *
     * If one already exists, it is updated with a new token value and the
     * request time is updated.
     *
     * @param  User  $user
     * @return PasswordReset Latest password reset token.
     */
    public function createOrUpdateResetToken(User $user)
    {
        $PasswordReset = $this->model->where([
            ['user_id', '=', $user->id],
            ['time_requested', '<', time() - PasswordReset::TOKEN_EXPIRATION_SECONDS],
        ])->first();

        $resetToken = Str::random(PasswordReset::TOKEN_LENGTH);

        if (!empty($PasswordReset)) {
            $PasswordReset->time_requested = time();
            $PasswordReset->token = $resetToken;
            $PasswordReset->save();
        } else {
            $data = [
                'user_id' => $user->id,
                'time_requested' => time(),
                'token' => $resetToken,
            ];
            $PasswordReset = $this->create($data);
        }

        return $PasswordReset;
    }

    /**
     * Create a new extended password reset token for the specified user.
     */
    public function createExtendedResetToken(User $user, Carbon $expireTime)
    {
        $resetToken = $this->helperService->randomString(PasswordReset::TOKEN_LENGTH);

        $data = [
            'user_id' => $user->id,
            'time_requested' => time(),
            'token' => $resetToken,
            'extended_token_expiration' => $expireTime->getTimestamp(),
        ];

        $PasswordReset = $this->create($data);

        return $PasswordReset;
    }

    /**
     * Generate URL to set password page.
     */
    public function buildSetPasswordUrl(string $username, string $token): string
    {
        if (empty($token) || strlen($token) < PasswordReset::TOKEN_LENGTH) {
            throw new Exception('Invalid token.');
        }

        $username = rawurlencode($username);

        return url("login/set_password.php?token={$token}&username={$username}");
    }

    /**
     * Get standard 'forgot password' reset token for the given user.
     */
    public function getByUser(User $user)
    {
        return PasswordReset::where('user_id', $user->id)->first();
    }
}
