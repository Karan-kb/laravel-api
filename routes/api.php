<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/students',[StudentController::class, 'index']);
Route::post('/students',[StudentController::class, 'store']);
Route::post('/students/store-all',[StudentController::class, 'storeAll']);

Route::get('/students/{id}',[StudentController::class, 'show']);

Route::get('/students/{id}/edit',[StudentController::class, 'edit']);

Route::put('/students/{id}/edit',[StudentController::class, 'update']);

Route::delete('/students/{id}/delete',[StudentController::class, 'destroy']);

Route::delete('/students/delete-all',[StudentController::class, 'destroyAll']);




