<?php

namespace App\Hr\Services;

use App\Hr\Models\Ball;
use App\Hr\Models\Bucket;
use App\Hr\Services\Contracts\CapacityServiceInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

final class CapacityService implements CapacityServiceInterface
{
    public function suggestBucket(array $attributes = [])
    {
        $ballData = data_get($attributes, 'balls');

        foreach ($ballData as $ballDatum) {
            $ballIds [] = $ballDatum['id'];
        }

        $ballCollection = Ball::whereIn('id', $ballIds)->get();
        $capacity = 0;

        foreach ($ballData as $ballDatum)
        {
            $capacity += $ballDatum['quantity'] * $ballCollection->where('id', $ballDatum['id'])->pluck('volume')->first();
        }

        $bucketData = Bucket::get();
        $emptyBucketVolumeCollection = collect();
        $bucketCapacity = 0;

        foreach ($bucketData as $bucketDatum) {
            $bucketCapacity += $bucketDatum->volume;
            $emptyBucketVolumeCollection->push([
                'id' => $bucketDatum->id,
                'name' => $bucketDatum->name,
                'volume' => $bucketDatum->volume,
                'rem_volume' => $bucketDatum->volume - $bucketDatum->occupied_volume
            ]);
        }

        if ($capacity > $bucketCapacity){
            throw new BadRequestException('Ball cannot be allocated');
        }

        $updatedBucketData = [];

        foreach ($emptyBucketVolumeCollection as $emptyVolumeBucket) {
            if ($capacity<=0) {
                break;
            }

            if ($capacity <= $emptyVolumeBucket['rem_volume']) {
                $updatedBucketData [] = [
                    'id' => $emptyVolumeBucket['id'],
                    'name' => $emptyVolumeBucket['name'],
                    'volume' => $emptyVolumeBucket['volume'],
                    'occupied_volume' => $capacity
                ];

                $capacity = 0;
            } else {
                $updatedBucketData [] = [
                    'id' => $emptyVolumeBucket['id'],
                    'name' => $emptyVolumeBucket['name'],
                    'volume' => $emptyVolumeBucket['volume'],
                    'occupied_volume' => $emptyVolumeBucket['volume']
                ];

                $capacity = $capacity - $emptyVolumeBucket['rem_volume'];
            }
        }

        Bucket::upsert($updatedBucketData, ['id','name'], ['volume', 'occupied_volume']);

        return $updatedBucketData;
    }

}

