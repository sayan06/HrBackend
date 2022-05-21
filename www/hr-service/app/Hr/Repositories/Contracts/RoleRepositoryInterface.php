<?php

namespace App\Hr\Repositories\Contracts;

use App\Hr\DataTransferObjects\FilterableDto;
use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    public function getMany(SortableDto $sortableDto, FilterableDto $filterableDto, int $pageLimit = 15): LengthAwarePaginator;

    public function updateOne(Role $role, array $attributes): Role;
}
