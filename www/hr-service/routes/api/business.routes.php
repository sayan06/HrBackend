<?php

use App\Hr\Controllers\api\v1\BusinessNatureController;
use Illuminate\Support\Facades\Route;

Route::get('/businesses', [BusinessNatureController::class, 'getAll'])
    ->middleware('permission:create_businesses');
