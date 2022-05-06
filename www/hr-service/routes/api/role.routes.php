<?php

use App\Hr\Controllers\api\v1\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/roles', [RoleController::class, 'getRoles'])
        ->middleware('permission:list_roles');

Route::get('/roles/{role}/permissions', [RoleController::class, 'getPermissionsByRole'])
    ->middleware('permission:list_role_permissions');

Route::post('/roles/{role}', [RoleController::class, 'assignPermissionsToRole'])
    ->middleware('permission:assign_permissions');

Route::post('/roles', [RoleController::class, 'create'])
    ->middleware('permission:create_roles');

Route::put('/roles/{role}', [RoleController::class, 'update'])
    ->middleware('permission:update_roles');

Route::delete('/roles/{role}', [RoleController::class, 'delete'])
    ->middleware('permission:delete_roles');
