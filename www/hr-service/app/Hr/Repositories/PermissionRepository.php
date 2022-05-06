<?php

namespace App\Hr\Repositories;

use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\Permission;
use App\Hr\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct()
    {
        $this->model = Permission::class;
    }

    public function getMany(SortableDto $sortableDto, int $pageLimit = 15): LengthAwarePaginator
    {
        return Permission::orderBy($sortableDto->getColumn(), $sortableDto->getOrder())
            ->paginate($pageLimit);
    }
}
