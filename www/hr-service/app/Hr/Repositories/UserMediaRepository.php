<?php

namespace App\Hr\Repositories;

use App\Hr\Models\UserMedia;
use App\Hr\Repositories\Contracts\UserMediaRepositoryInterface;

final class UserMediaRepository extends BaseRepository implements UserMediaRepositoryInterface
{
    public function __construct()
    {
        $this->model = UserMedia::class;
    }

    public function createMedia(array $userMediaDetails): bool
    {
        return UserMedia::insert($userMediaDetails);
    }

    public function update(UserMedia $userMedia, array $userMediaDetails): UserMedia
    {
        $userMedia->is_default = data_get($userMediaDetails, 'is_default') ?? $userMedia->is_default;
        $userMedia->is_enabled = data_get($userMediaDetails, 'is_enabled') ?? $userMedia->is_enabled;
        $userMedia->name = data_get($userMediaDetails, 'name') ?? $userMedia->name;
        $userMedia->path = data_get($userMediaDetails, 'path') ?? $userMedia->path;
        $userMedia->type = data_get($userMediaDetails, 'type') ?? $userMedia->type;

        $userMedia->update();

        return $userMedia;
    }

    public function delete(UserMedia $userMedia): bool|null
    {
        return $userMedia->delete();
    }
}
