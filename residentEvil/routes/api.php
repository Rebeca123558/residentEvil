<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/', [AuthController::class, 'register']);
Route::post('/', [AuthController::class, 'Login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user',fn(Request $request)=>$request->user);

   

});