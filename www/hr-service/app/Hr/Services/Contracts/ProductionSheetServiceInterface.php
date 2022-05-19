<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\ProductionSheet;
use App\Hr\Models\User;

interface ProductionSheetServiceInterface
{
    public function get(ProductionSheet $productionSheet): ProductionSheet;

    public function createOne(ProductionSheet $manufacturingOutputSheet, User $user, array $partOutputData = []): ProductionSheet;

    public function updateOne(ProductionSheet $productionSheet, User $user, array $partOutputData = []): ProductionSheet;

    public function delete(ProductionSheet $productionSheet);
}
