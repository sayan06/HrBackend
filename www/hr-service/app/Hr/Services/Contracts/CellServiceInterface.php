<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Cell;
use Illuminate\Support\Collection;

interface CellServiceInterface
{
    public function deleteCell(Cell $cell);

    public function addCellItems(Cell $cell, Collection $stockableVariants): Cell;

    public function deleteCellItems(Cell $cell, Collection $itemVariants): Cell;
}
