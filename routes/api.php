<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\ItemController;
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

Route::group(['middleware' => 'auth:sanctum'], function() {
  Route::post("api-keys", [ApiKeyController::class, 'store']);
  Route::get("items", [ItemController::class, 'index']);
  Route::post("items", [ItemController::class, 'store']);
});
