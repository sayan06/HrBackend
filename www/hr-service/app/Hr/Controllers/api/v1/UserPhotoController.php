<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\Models\UserPhoto;
use App\Hr\Services\Contracts\UserPhotoServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserPhotoController extends ApiController
{
    private $userPhotoService;

    public function __construct(UserPhotoServiceInterface $userPhotoService)
    {
        $this->userPhotoService = $userPhotoService;
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'photos' => 'required',
            'photos.*' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        return $this->respondSuccess(
            'Files Created Successfully',
            $this->userPhotoService->create($request->user(), $request->file('photos'))
        );
    }

    public function update(Request $request, UserPhoto $userPhoto): JsonResponse
    {
        $request->validate([
            'is_default' => 'boolean',
            'is_enabled' => 'boolean',
            'photos.*' => 'file|mimes:jpg,jpeg,png',
            'user_id' => 'prohibited',
        ]);

        if (!$request->hasAny(['is_default', 'is_enabled']) && !$request->hasFile('photos')) {
            return $this->respondBadRequest('Nothing To Update');
        }

        return $this->respondSuccess(
            'File Updated Successfully',
            $this->userPhotoService->update($userPhoto, $request->all(), $request->file('photos'))
        );
    }

    public function get(UserPhoto $userPhoto): JsonResponse
    {
        return $this->respond($userPhoto->load('user'));
    }

    public function delete(UserPhoto $userPhoto): JsonResponse
    {
        return $this->respondSuccess(
            'File deleted successfully!',
            $this->userPhotoService->delete($userPhoto)
        );
    }
}
