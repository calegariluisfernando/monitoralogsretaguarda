<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ErrorController;
use App\Http\Middleware\FirebaseJwtMiddleware;
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

Route::post('/log-error', [ErrorController::class, 'store']);
Route::delete('/remove-linha-logs/{data}', [ErrorController::class, 'removeLinhaLogs']);
Route::delete('/log-error/{data}', [ErrorController::class, 'destroy']);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware([FirebaseJwtMiddleware::class])->prefix('/auth')->group(function (){
    Route::post('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    /*Route::post('refresh', [AuthController::class, 'refresh']);*/
});
