<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\KebunController;
use App\Http\Controllers\API\AlatIotController;
use App\Http\Controllers\API\JadwalSiramController;

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
Route::get('getAuthUser',[AuthController::class,'show'])->middleware('auth:api'); //get auth user
Route::get('getAll',[AuthController::class,'index'])->middleware('auth:api'); //get all users
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:api'); //logout
Route::patch('update',[AuthController::class,'update'])->middleware('auth:api'); //update user
Route::delete('delete',[AuthController::class,'destroy'])->middleware('auth:api'); //delete user

Route::apiResource('kebuns', KebunController::class)->middleware('auth:api'); //kebun resource
Route::get('allKebuns', [KebunController::class,'all'])->middleware('auth:api'); //get all kebuns

Route::apiResource('alats', AlatIotController::class);  //alat resource
Route::get('allAlats', [AlatIotController::class,'all'])->middleware('auth:api'); //get all alats
Route::patch('updateAlat',[AlatIotController::class,'update']);//->middleware('auth:api'); //update alat
Route::delete('deleteAlat',[AlatIotController::class,'destroy']);//->middleware('auth:api'); //delete alat

Route::apiResource('jadwals', JadwalSiramController::class)->middleware('auth:api');  //alat resource
Route::get('allJadwals', [JadwalSiramController::class,'all'])->middleware('auth:api'); //get all alats
