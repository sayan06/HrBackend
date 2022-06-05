<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Media;

interface MediaServiceInterface
{
    public function updateMediaItems(Media $media, array $attributes = [], array $mediaDetails = []);

    public function deleteMedia(Media $media): Media;
}
