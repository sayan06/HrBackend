<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\Permission;
use App\Hr\Repositories\Contracts\PermissionRepositoryInterface;
use App\Hr\Resources\PermissionResource;
use Illuminate\Http\Request;

final class PermissionController extends ApiController
{
    private const RULE_INT_MIN_1 = 'int|min:1';

    private $permissionRepository;

    public function __construct(
        PermissionRepositoryInterface $permissionRepository,
    ) {
        $this->permissionRepository = $permissionRepository;
    }

    public function getPermissions(Request $request)
    {
        $request->validate([
            'limit' => self::RULE_INT_MIN_1,
            'page' => self::RULE_INT_MIN_1,
        ]);

        $sortColumn = $request->input('col', 'id');
        $sortOrder = $request->input('order', 'desc');
        $pageLimit = $request->input('limit', config('hr.default_page_size'));

        $sortableDto = new SortableDto($sortColumn, $sortOrder, Permission::class);

        $permissionCollection = $this->permissionRepository->getMany($sortableDto, $pageLimit);

        return $this->respondPaginated(PermissionResource::collection($permissionCollection));
    }
}
