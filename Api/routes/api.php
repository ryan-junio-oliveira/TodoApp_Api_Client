<?php

use App\Http\Controllers\Api\V1\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function () {
    Route::controller(TodoController::class)->group(function () {
        Route::get('todos', 'index');
        Route::post('todos', 'store');
        Route::get('todos/{id}', 'show');
        Route::put('todos/{id}', 'update');
        Route::delete('todos/{id}', 'destroy');

        //personalized routes
        Route::get('todos/completed', 'getCompleted');
        Route::get('todos/pending', 'getPending');
    });
});
