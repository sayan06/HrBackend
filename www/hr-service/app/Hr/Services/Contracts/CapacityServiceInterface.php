<?php

namespace App\Hr\Services\Contracts;

interface CapacityServiceInterface
{
    public function suggestBucket(array $attributes = []);
}
