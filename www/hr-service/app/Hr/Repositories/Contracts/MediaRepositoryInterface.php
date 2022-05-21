<?php

namespace App\Hr\Repositories\Contracts;

use App\Hr\Models\EntityMedia;
use App\Hr\Models\Media;
use Illuminate\Database\Eloquent\Collection;

interface MediaRepositoryInterface
{
    public function updateMediaDetails(Media $media, array $attributes, array $mediaDetails): Media;

    public function updateMediaEntityDetails(Media $media, array $attributes, array $mediaDetails): EntityMedia;

    public function getMediaItems(Media $media, array $attributes): Collection;

    public function deleteOne(Media $media): Media;

    public function deleteByMedia(Media $media);
}
