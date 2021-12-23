<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->post('/hello/sort', [\App\Http\Controllers\HelloController::class, 'sort']);
// Resource
Route::middleware('auth:sanctum')->resource('hello', \App\Http\Controllers\HelloController::class);
