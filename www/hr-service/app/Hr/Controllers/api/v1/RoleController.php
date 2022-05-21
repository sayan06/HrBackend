<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\DataTransferObjects\FilterableDto;
use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\Permission;
use App\Hr\Models\Role;
use App\Hr\Repositories\Contracts\RoleRepositoryInterface;
use App\Hr\Resources\PermissionResource;
use App\Hr\Resources\RoleResource;
use App\Hr\Services\Contracts\RoleServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class RoleController extends ApiController
{
    private const RULE_INT_MIN_1 = 'int|min:1';

    private $roleRepository;
    private $roleService;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        RoleServiceInterface $roleService
    ) {
        $this->roleRepository = $roleRepository;
        $this->roleService = $roleService;
    }

    public function getRoles(Request $request)
    {
        $request->validate([
            'limit' => self::RULE_INT_MIN_1,
            'page' => self::RULE_INT_MIN_1,
        ]);

        $sortColumn = $request->input('col', 'id');
        $sortOrder = $request->input('order', 'desc');
        $filters = $request->input('filters', []);
        $pageLimit = $request->input('limit', config('hr.default_page_size'));

        $sortableDto = new SortableDto($sortColumn, $sortOrder, Role::class);
        $filterableDto = new FilterableDto($filters, Role::class);

        $roleCollection = $this->roleRepository->getMany($sortableDto, $filterableDto, $pageLimit);

        return $this->respondPaginated(RoleResource::collection($roleCollection));
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:200|unique:roles,name',
            'guard_name' => 'prohibited',
        ];

        $request->validate($rules);
        $attributes = [
            'name' => $request->name,
            'guard_name' => 'web',
        ];

        $role = Role::create($attributes);

        return $this->respondCreated('Role created successfully.', new RoleResource($role));
    }

    public function update(Role $role, Request $request)
    {
        $rules = [
            'name' => 'string|max:200|unique:roles,name,' . $role->id,
            'guard_name' => 'prohibited',
        ];

        $request->validate($rules);

        $role = $this->roleRepository->updateOne($role, $request->all());

        return $this->respondSuccess('Role updated successfully.', new RoleResource($role));
    }

    public function delete(Role $role)
    {
        return $this->respondSuccess('Role successfully deleted.', new RoleResource($this->roleService->delete($role)));
    }

    public function assignPermissionsToRole(Role $role, Request $request)
    {
        $rules = [
            'permission_ids' => 'array',
        ];

        $request->validate($rules);

        if ($role->isGuest()) {
            throw new BadRequestException('Guest are allowed to have default permissions only');
        }

        $permissions = Permission::findOrFail($request->permission_ids);
        $role->syncPermissions($permissions);

        return $this->respondSuccess(
            'Permissions assigned successfully!',
            PermissionResource::collection($role->permissions)
        );
    }

    public function getPermissionsByRole(Role $role)
    {
        return $this->respond(PermissionResource::collection($role->permissions));
    }
}
