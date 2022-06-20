<?php

namespace App\Hr\Services;

use App\Exceptions\BusinessRuleViolationException;
use App\Hr\Mail\DefaultMailable;
use App\Hr\Models\Config;
use App\Hr\Models\EmailLog;
use App\Hr\Models\Notification;
use App\Hr\Models\PasswordHistory;
use App\Hr\Models\PasswordReset;
use App\Hr\Models\User;
use App\Hr\Repositories\Contracts\PasswordResetRepositoryInterface;
use App\Hr\Services\Contracts\PasswordResetServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Throwable;

final class PasswordResetService implements PasswordResetServiceInterface
{
    private user $user;
    private PasswordResetRepositoryInterface $passwordResetRepo;

    public function __construct(
        PasswordResetRepositoryInterface $passwordResetRepo,
    ) {
        $this->passwordResetRepo = $passwordResetRepo;
    }

    public function findUser(string $searchValue): User
    {
        $user = User::where([
            'email' => $searchValue,
        ])->get();

        if ($user->count() === 0) {
            throw new ModelNotFoundException('No user found');
        }

        if ($user->count() > 1) {
            throw new BusinessRuleViolationException('Multiple users found');
        }

        return $user->first();
    }

    public function sendResetEmail(User $user): PasswordReset
    {
        $passwordResetData = $this->getUserPasswordResetData($user);
        $notification = $this->createNotification($user);

        $this->processNotification($notification, $passwordResetData);

        return $passwordResetData;
    }

    public function resetPasswordByToken(string $token, string $password): void
    {
        try {
            $passwordResetData = PasswordReset::where('token', $token)->with('user')->firstOrFail();
            $this->validatePasswordResetData($passwordResetData);

            $this->user = $passwordResetData->user;
        } catch (Throwable $th) {
            if (!empty($passwordResetData)) {
                $passwordResetData->delete();
            }

            throw $th;
        }

        try {
            DB::beginTransaction();

            $passwordResetData->delete();

            $this->user->password = $password;
            $this->user->save();

            $this->addPasswordHistory($password);
            $this->deleteUserSessions();

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function getUser(): User
    {
        return $this->user;
    }

    private function getUserPasswordResetData(User $user): PasswordReset
    {
        $passwordResetRecord = $this->passwordResetRepo->getByUser($user);
        dd($passwordResetRecord);
        if (empty($passwordResetRecord->token)) {
            return $this->passwordResetRepo->createOrUpdateResetToken($user);
        }

        if (time() > ($passwordResetRecord->time_requested + PasswordReset::TOKEN_EXPIRATION_SECONDS)) {
            $passwordResetRecord->delete();

            return $this->passwordResetRepo->createOrUpdateResetToken($user);
        }

        return $passwordResetRecord;
    }

    private function validatePasswordResetData(PasswordReset $passwordResetData): void
    {
        if (empty($passwordResetData) || $passwordResetData->time_requested < (time() - PasswordReset::TOKEN_EXPIRATION_SECONDS)) {
            throw new NotFoundResourceException('Invalid password reset data.');
        }
    }

    private function addPasswordHistory(string $password): void
    {
        $passwordReuseLimit = Config::where('name', 'password_reuse_limit')->get()->first()?->value;

        if (empty($passwordReuseLimit) || $passwordReuseLimit < 0) {
            return;
        }

        PasswordHistory::insert([
            'hash' => bcrypt($password),
            'created_at' => time(),
            'user_id' => $this->user->id,
        ]);

        $passwordHistories = PasswordHistory::where('user_id', $this->user->id)->orderByDesc('id')->get();

        $index = 0;
        $idsToDelete = [];

        foreach ($passwordHistories as $passwordHistory) {
            $index++;
            if ($index > $passwordReuseLimit) {
                $idsToDelete[] = $passwordHistory->id;
            }
        }

        if (!empty($idsToDelete)) {
            PasswordHistory::whereIn('id', $idsToDelete)->delete();
        }
    }

    private function deleteUserSessions(): void
    {
        $this->user->tokens()->delete();
    }

    private function createNotification(User $user): Notification
    {
        $notification = new Notification();

        $notification->event_type = Notification::EVENT_TYPE_RESET_PASSWORD;
        $notification->sender_email = config('mail.from.address');
        $notification->recipient_email = $user->email;
        $notification->time_to_send = time();

        $notification->save();

        return $notification;
    }

    private function processNotification(Notification $notification, PasswordReset $PasswordReset)
    {
        $recipient = $notification->recipient;

        $body = $PasswordReset->token;
        $subject = 'Reset Password';

        $defaultMailable = new DefaultMailable([
            'body' => $body,
            'title' => $subject,
        ]);

        Mail::to($recipient->email)->send($defaultMailable);
        Log::debug("Password reset notification sent to {$recipient->email}");

        $this->markNotificationAsSent($notification);
        $this->saveEmailLog($recipient, $notification, $subject, $body);

        return $notification;
    }

    private function markNotificationAsSent(Notification $notification)
    {
        $notification->is_processed = 1;
        $notification->is_sent = 1;

        $notification->save();

        return $notification;
    }

    private function saveEmailLog(User $recipient_email, Notification $notification, string $subject, string $body)
    {
        $emailLog = new EmailLog();

        $emailLog->notification_id = $notification->id;
        $emailLog->sender_email = config('mail.from.address');
        $emailLog->recipient_email = $recipient_email->email;
        $emailLog->subject = $subject;
        $emailLog->body = $body;
        $emailLog->time_sent = time();

        $emailLog->save();
    }
}
