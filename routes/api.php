<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\UserPermissionController;

// REST API Routes (no CSRF)
Route::apiResource('companies', CompanyController::class);
Route::apiResource('centers', CenterController::class);
Route::apiResource('user-permissions', UserPermissionController::class);
