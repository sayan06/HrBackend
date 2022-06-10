<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\Models\UserMedia;
use App\Hr\Services\Contracts\UserMediaServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

final class UserMediaController extends ApiController
{
    private $userMediaService;

    public function __construct(UserMediaServiceInterface $userMediaService)
    {
        $this->userMediaService = $userMediaService;
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'media' => 'required',
            'media.*' => 'required|file|mimes:jpg,jpeg,png,mp4',
            'type' => 'required|string'
        ]);

        return $this->respondSuccess(
            'Files Uploaded Successfully',
            $this->userMediaService->create($request->user(), $request->all(), $request->file('media'))
        );
    }

    public function update(Request $request, UserMedia $userMedia): JsonResponse
    {
        $request->validate([
            'is_default' => 'boolean',
            'is_enabled' => 'boolean',
            'media.*' => 'file|mimes:jpg,jpeg,png,mp4',
            'type' => 'string',
            'user_id' => 'prohibited',
        ]);

        if (!$request->hasAny(['is_default', 'is_enabled', 'type']) && !$request->hasFile('media')) {
            return $this->respondBadRequest('Nothing To Update');
        }

        return $this->respondSuccess(
            'File Updated Successfully',
            $this->userMediaService->update($userMedia, $request->all(), $request->file('media'))
        );
    }

    public function get(UserMedia $userMedia): JsonResponse
    {
        return $this->respond($userMedia->load('user'));
    }

    public function delete(UserMedia $userMedia): JsonResponse
    {
        return $this->respondSuccess(
            'File deleted successfully!',
            $this->userMediaService->delete($userMedia)
        );
    }
}
