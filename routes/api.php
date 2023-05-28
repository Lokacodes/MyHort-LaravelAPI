<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\KebunController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']); //register
Route::post('login',[AuthController::class,'login']); //login
Route::get('getAll',[AuthController::class,'index'])->middleware('auth:api'); //get all users
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:api'); //logout

Route::apiResource('kebuns', KebunController::class)->middleware('auth:api'); //kebun resource
Route::get('allKebuns', [KebunController::class,'all'])->middleware('auth:api'); //get all kebuns

Route::apiResource('alats', AlatIotController::class)->middleware('auth:api');  //alat resource
Route::get('allAlats', [AlatIotController::class,'all'])->middleware('auth:api'); //get all alats
