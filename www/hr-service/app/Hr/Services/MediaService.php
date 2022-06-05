<?php

namespace App\Hr\Services;

use App\Hr\Models\Media;
use App\Hr\Repositories\Contracts\MediaRepositoryInterface;
use App\Hr\Services\Contracts\MediaServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

final class MediaService implements MediaServiceInterface
{
    private $mediaRepo;

    public function __construct(MediaRepositoryInterface $mediaRepo)
    {
        $this->mediaRepo = $mediaRepo;
    }

    public function updateMediaItems(Media $media, array $attributes = [], array $mediaDetails = [])
    {
        try {
            DB::beginTransaction();

            $this->mediaRepo->updateMediaDetails($media, $attributes, $mediaDetails);
            $this->mediaRepo->updateMediaEntityDetails($media, $attributes, $mediaDetails);

            DB::commit();

        } catch (Exception $ex) {
            DB::rollBack();

            throw $ex;
        }
    }

    public function deleteMedia(Media $media): Media
    {
        try {
            DB::beginTransaction();

            $this->mediaRepo->deleteByMedia($media);

            $media = $this->mediaRepo->deleteOne($media);

            DB::commit();

            return $media;
        } catch (Exception $ex) {
            DB::rollBack();

            throw $ex;
        }
    }

}
