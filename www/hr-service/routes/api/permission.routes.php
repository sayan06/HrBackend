<?php

use App\Hr\Controllers\api\v1\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/permissions', [PermissionController::class, 'getPermissions'])
        ->middleware('permission:list_permissions');

