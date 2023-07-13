<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ErrorController;
use app\Http\Middleware\FirebaseJwtMiddleware;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/log-error', [ErrorController::class, 'store']);
Route::delete('/remove-linha-logs/{data}', [ErrorController::class, 'removeLinhaLogs']);
Route::delete('/log-error/{data}', [ErrorController::class, 'destroy']);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware([FirebaseJwtMiddleware::class])->group(function (){

});
