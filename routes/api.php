<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware'=>'api','prefix'=>'auth'],function($router){
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    Route::get('/profile',[AuthController::class,'profile']);
    Route::post('/logout',[AuthController::class,'logout']);
});

Route::group(['middleware'=>'api','prefix'=>'task'],function($router){
    Route::post('/create',[TaskController::class,'store']);
    Route::post('/update/{id}',[TaskController::class,'update']);
    Route::post('/delete/{id}',[TaskController::class,'destroy']);
    Route::post('/view/{id}',[TaskController::class,'show']);
    Route::get('/dump',[TaskController::class,'index']);
});