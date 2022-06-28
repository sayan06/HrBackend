<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\Models\Bucket;
use App\Hr\Models\Ball;
use App\Hr\Services\Contracts\CapacityServiceInterface;
use Illuminate\Http\Request;

final class BucketFillingController extends ApiController
{
    private $capacityService;

    public function __construct(
        CapacityServiceInterface $capacityService,
    ) {
        $this->capacityService = $capacityService;
    }

    public function indexBalls()
    {
        return $this->respond(Ball::all());
    }

    public function indexBuckets()
    {
        return $this->respond(Bucket::all());
    }

    public function bucketSelection(Request $request)
    {
        $request->validate([
            'balls' => 'required|array',
            'balls.*.id' => 'required|exists:balls,id',
            'balls.*.quantity' => 'required|numeric|min:1|max:9999999999',
        ]);

        return $this->respondSuccess('The ball is distributed Successfully', $this->capacityService->suggestBucket($request->all()));
    }
}
