<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/cars')->group(function () {
    Route::get('/', [CarController::class, 'index'])->name('car.index');
    Route::post('/', [CarController::class, 'store'])->name('car.store');
    Route::get('/{car}/edit', [CarController::class, 'edit'])->name('car.edit');
    Route::patch('/{car}', [CarController::class, 'update'])->name('car.update');
    Route::delete('/{car}', [CarController::class, 'destroy'])->name('car.destroy');
});


Route::get('users/{user}/edit', [UserController::class, 'edit']);

