<?php

use App\Http\Controllers\FarmFieldController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

const FARM_FIELD_PARAMETER_REGEXP = '^(1[0-8]|[1-9])$'; // 1-18 inclusively

// Profile related routes
Route::apiSingleton('profile', ProfileController::class);

// Game related routes
Route::name('game.')->prefix('game')->group(function() {
    Route::name('farm-fields.')->prefix('/farm-fields')->group(function() {
        Route::get('/', [FarmFieldController::class, 'list'])
            ->name('list');
        Route::get('/{farmField}', [FarmFieldController::class, 'get'])
            ->name('get')
            ->where([
                'farmField' => FARM_FIELD_PARAMETER_REGEXP
            ]);
        Route::post('/{farmField}/plant/{seed}', [FarmFieldController::class, 'plant'])
            ->name('plant')
            ->can('plant', ['farmField', 'seed'])
            ->where([
                'farmField' => FARM_FIELD_PARAMETER_REGEXP
            ])
            ->whereNumber('seed');
    });

    Route::name('warehouses.')->prefix('/warehouses')->group(function() {
        Route::get('/{warehouseNumber?}', [WarehouseController::class, 'list'])
            ->name('list')
            ->whereNumber('warehouseNumber');
    });
});

Route::get('/redis-test', function() {
    Redis::connection('default')->publish('test_channel', 'test message');

    return response()->noContent();
});
