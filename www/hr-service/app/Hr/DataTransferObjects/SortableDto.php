<?php

namespace App\Hr\DataTransferObjects;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class SortableDto
{
    const SORT_ORDERS = ['asc', 'desc'];

    private string $sortColumn;
    private string $sortOrder;

    public function __construct(string $sortColumn, string $sortOrder, $modelClass = null)
    {
        if (!in_array($sortOrder, self::SORT_ORDERS)) {
            throw new BadRequestException('Invalid sort order.');
        }

        if (!empty($modelClass) && !in_array($sortColumn, $modelClass::SORTABLE)) {
            throw new BadRequestException('Column ' . $sortColumn . ' is not sortable.');
        }

        $this->sortColumn = $sortColumn;
        $this->sortOrder = $sortOrder;
    }

    public function getColumn(): string
    {
        return $this->sortColumn;
    }

    public function getOrder(): string
    {
        return $this->sortOrder;
    }
}
