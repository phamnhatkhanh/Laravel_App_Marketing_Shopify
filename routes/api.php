<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helpers\Routes\RouteHelper;
use App\Http\Controllers\JwtAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProductRequest;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products',ProductController::class);
Route::prefix('auth')->group(function (){
        RouteHelper::includeRouteFiles(__DIR__ . '/api/jwt');

});

RouteHelper::includeRouteFiles(__DIR__ . '/api/v1');
