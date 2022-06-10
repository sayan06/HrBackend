<?php

namespace App\Hr\Repositories;

use App\Hr\Models\UserPost;
use App\Hr\Repositories\Contracts\UserPostRepositoryInterface;

final class UserPostRepository extends BaseRepository implements UserPostRepositoryInterface
{
    public function __construct()
    {
        $this->model = UserPost::class;
    }

    public function create(array $userPostDetails): UserPost
    {
        return UserPost::create($userPostDetails);
    }

    public function update(UserPost $userPost, array $userPostDetails): UserPost
    {
        $userPost->description = data_get($userPostDetails, 'description', $userPost->description);
        $userPost->hashtags = data_get($userPostDetails, 'hashtags', $userPost->hashtags);
        $userPost->post_visibility_id = data_get($userPostDetails, 'post_visibility_id', $userPost->post_visibility_id);
        $userPost->title = data_get($userPostDetails, 'title', $userPost->title);

        $userPost->update();

        return $userPost->load('media', 'user', 'visibility');
    }

    public function delete(UserPost $userPost): bool|null
    {
        return $userPost->delete();
    }
}
