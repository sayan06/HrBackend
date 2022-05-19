<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Item;

interface ItemServiceInterface
{
    public function create(array $itemData): Item;
    public function update(Item $item, array $itemData): Item;
    public function delete(Item $item): Item;
}
