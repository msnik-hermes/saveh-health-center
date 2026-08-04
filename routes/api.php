<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FacilityRequestController;
use App\Http\Controllers\Api\ItRequestController;
use App\Http\Controllers\Api\VehicleRequestController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/facility-requests', [FacilityRequestController::class, 'index']);
        Route::post('/facility-requests', [FacilityRequestController::class, 'store']);
        Route::get('/facility-requests/{facilityRequest}', [FacilityRequestController::class, 'show']);

        Route::get('/it-requests', [ItRequestController::class, 'index']);
        Route::post('/it-requests', [ItRequestController::class, 'store']);
        Route::get('/it-requests/{itRequest}', [ItRequestController::class, 'show']);

        Route::get('/vehicle-requests', [VehicleRequestController::class, 'index']);
        Route::post('/vehicle-requests', [VehicleRequestController::class, 'store']);
        Route::get('/vehicle-requests/{vehicleRequest}', [VehicleRequestController::class, 'show']);
    });
});

// Legacy open endpoints (kept temporarily; prefer /api/v1 + Sanctum)
Route::apiResource('companies', CompanyController::class);
Route::apiResource('centers', CenterController::class);
Route::apiResource('employees', EmployeeController::class);
Route::apiResource('user-permissions', UserPermissionController::class);
