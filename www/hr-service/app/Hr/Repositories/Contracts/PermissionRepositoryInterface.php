<?php

namespace App\Hr\Repositories\Contracts;

use App\Hr\DataTransferObjects\SortableDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PermissionRepositoryInterface
{
    public function getMany(SortableDto $sortableDto, int $pageLimit = 15): LengthAwarePaginator;
}
