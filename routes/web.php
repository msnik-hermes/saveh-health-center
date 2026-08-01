<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

Route::get('/', function () {
    return view('welcome');
});

// REST API Routes for Company
Route::get('/companies', [CompanyController::class, 'index']);
Route::get('/companies/{company}', [CompanyController::class, 'show']);
Route::post('/companies', [CompanyController::class, 'store']);
Route::put('/companies/{company}', [CompanyController::class, 'update']);
Route::delete('/companies/{company}', [CompanyController::class, 'destroy']);
