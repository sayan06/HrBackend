<?php

namespace App\Hr\DataTransferObjects;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class FilterableDto
{
    const OPERANDS = [
        'equal' => '=',
        'gt' => '>',
        'gte' => '>=',
        'like' => 'LIKE',
        'lt' => '<',
        'lte' => '<=',
        'not' => '!=',
    ];

    private array $filters = [];
    private array $whereInFilters = [];

    public function __construct(array $filterArray, $modelClass = null)
    {
        if (empty($modelClass::FILTERABLES)) {
            throw new BadRequestException('Model is not filterable.');
        }

        foreach ($filterArray as $column => $condition) {
            if (!empty($modelClass) && !in_array($column, $modelClass::FILTERABLES)) {
                throw new BadRequestException('Column ' . $column . ' is not filterable.');
            }

            $condition = explode(':', $condition);

            if (count($condition) == 1) {
                $this->filters[] = [$column, $condition[0]];
                continue;
            }

            if ($condition[0] == 'in') {
                $this->whereInFilters[$column] = explode(',', $condition[1]);
                continue;
            }

            if (empty(data_get(self::OPERANDS, $condition[0]))) {
                throw new BadRequestException('Invalid operand ' . $condition[0] . '.');
            }

            $this->filters[] = [$column, data_get(self::OPERANDS, $condition[0]), $condition[1] == 'null' ? null : $condition[1]];
        }
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getWhereInFilters(): array
    {
        return $this->whereInFilters;
    }
}
