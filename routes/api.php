<?php

use App\Http\Controllers\ErrorsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Project Keys routes
Route::post('/errors/new', [ErrorsController::class, 'create'])->middleware('project_key');