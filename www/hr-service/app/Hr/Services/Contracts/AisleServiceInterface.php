<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Aisle;

interface AisleServiceInterface
{
    public function create(array $aisleData): Aisle;

    public function delete(Aisle $aisle): Aisle;

    public function update(Aisle $aisle, array $aisleData): Aisle;
}
