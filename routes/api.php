<?php

use App\Http\Controllers\FarmFieldController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Profile related routes
Route::apiSingleton('profile', ProfileController::class);

// Game related routes
Route::name('game.')->prefix('game')->group(function() {
    Route::name('farm-fields.')->prefix('/farm-fields')->group(function() {
        Route::get('/', [FarmFieldController::class, 'list'])
            ->name('list');
        Route::get('/{farmField}', [FarmFieldController::class, 'get'])
            ->name('get');
        Route::post('/{farmField}/plant/{crop}', [FarmFieldController::class, 'plant'])
            ->name('plant')
            ->can('plant', ['farmField', 'crop']);
    })->where([
        'farmField' => '^(1[0-8]|[1-9])$' // 1-18 inclusively
    ])->whereNumber('crop');
});