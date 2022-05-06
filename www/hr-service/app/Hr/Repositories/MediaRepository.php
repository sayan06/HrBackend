<?php

namespace App\Hr\Repositories;

use App\Hr\Models\EntityMedia;
use App\Hr\Models\Media;
use App\Hr\Repositories\Contracts\MediaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class MediaRepository extends BaseRepository implements MediaRepositoryInterface
{
    public function __construct()
    {
        $this->model = Media::class;
    }

    public function updateMediaDetails(Media $media, array  $attributes, array $mediaDetails): Media
    {
        $media->name = data_get($mediaDetails, 'name');
        $media->path = data_get($mediaDetails, 'path');
        $media->media_type_id = data_get($attributes, 'media_type_id');
        $media->created_by = data_get($mediaDetails, 'created_by');

        $media->save();

        return $media;
    }

    public function updateMediaEntityDetails(Media $media, array  $attributes, array $mediaDetails): EntityMedia
    {
        return tap(new EntityMedia(), function ($entityMedia) use ($attributes, $mediaDetails, $media) {
            $entityMedia->entity_id = data_get($attributes, 'entity_id');
            $entityMedia->media_id = $media->id;
            $entityMedia->entity = data_get($mediaDetails, 'reference_model');

            $entityMedia->save();
        });
    }

    public function getMediaItems(Media $media, array $attributes): Collection
    {
        $mediaId = EntityMedia::where('entity', $attributes['entity'])
            ->where('entity_id', $attributes['entity_id'])
            ->pluck('media_id');

        $mediaLocation = Media::whereIn('id', $mediaId)->get();

        return $mediaLocation;
    }

    public function deleteOne(Media $media): Media
    {
        return tap($media)->delete();
    }

    public function deleteByMedia(Media $media)
    {
        return EntityMedia::where('media_id', $media->id)->delete();
    }
}
