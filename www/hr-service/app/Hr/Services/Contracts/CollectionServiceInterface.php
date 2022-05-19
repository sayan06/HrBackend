<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Collection as HrCollection;

interface CollectionServiceInterface
{
    public function addToCollection(HrCollection $collection, array $itemVariantQuantities): HrCollection;

    public function deleteFromCollection(HrCollection $collection, array $itemVariantQuantities): HrCollection;

    public function updateCollectionItems(HrCollection $collection, array $itemVariantQuantities): HrCollection;
}
