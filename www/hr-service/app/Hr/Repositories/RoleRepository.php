<?php

namespace App\Hr\Repositories;

use App\Hr\DataTransferObjects\FilterableDto;
use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\Role;
use App\Hr\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct()
    {
        $this->model = Role::class;
    }

    public function getMany(SortableDto $sortableDto, FilterableDto $filterableDto, int $pageLimit = 15): LengthAwarePaginator
    {
        return Role::where($filterableDto->getFilters())
            ->orderBy($sortableDto->getColumn(), $sortableDto->getOrder())
            ->paginate($pageLimit);
    }

    public function updateOne(Role $role, array $attributes): Role
    {
        $role->name = data_get($attributes, 'name', $role->name);

        $role->save();

        return $role;
    }
}
