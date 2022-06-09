<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\Models\UserPost;
use App\Hr\Services\Contracts\UserPostServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserPostController extends ApiController
{
    private UserPostServiceInterface $userPostService;

    public function __construct(UserPostServiceInterface $userPostService)
    {
        $this->userPostService = $userPostService;
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'string|max:255',
            'description' => 'required|string|max:255',
            'hashtags' => 'string|max:255',
            'post_visibility_id' => 'required|integer|exists:user_post_visibilities,id',
            'media.*' => 'file|mimes:jpg,jpeg,png,mp4',
            'media_type' => 'string|required_with:media'
        ]);

        return $this->respondSuccess(
            'Post Created Successfully',
            $this->userPostService->create($request->user(), $request->all(), $request->file('media'))
        );
    }

    public function update(Request $request, UserPost $userPost): JsonResponse
    {
        $request->validate([
            'title' => 'string|max:255',
            'description' => 'string|max:255',
            'hashtags' => 'string|max:255',
            'post_visibility_id' => 'integer|exists:user_post_visibilities,id',
            'media.*' => 'file|mimes:jpg,jpeg,png,mp4',
            'media_type' => 'string|required_with:media'
        ]);

        if (!$request->hasAny(['title', 'description', 'hashtags', 'post_visibility_id']) && !$request->hasFile('media')) {
            return $this->respondBadRequest('Nothing To Update');
        }

        return $this->respondSuccess(
            'Post Updated Successfully',
            $this->userPostService->update($userPost, $request->all(), $request->file('media'))
        );
    }

    public function get(UserPost $userPost): JsonResponse
    {
        return $this->respond($userPost->load('media', 'user', 'visibility'));
    }

    public function delete(UserPost $userPost): JsonResponse
    {
        return $this->respondSuccess(
            'File deleted successfully!',
            $this->userPostService->delete($userPost)
        );
    }
}
