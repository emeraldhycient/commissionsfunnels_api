<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::get('/', function () {
    return response()->json([
        'success' => 'Welcome to the commissionsfunnels API',
    ], 200);
});

Route::post("/createaccount", [AuthController::class, "createaccount"]);
Route::post("/login", [AuthController::class, "login"]);