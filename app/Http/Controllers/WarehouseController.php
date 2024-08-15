<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class WarehouseController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return ['auth:sanctum'];
    }

    /**
     * Retrieve a list of all warehouses of the user and load slots of a warehouse that has its number
     * field matching with the route parameter $warehouseNumber
     */
    public function list(Request $request, ?string $warehouseNumber = null)
    {
        // Retrieve all warehouses of the user
        $user = $request->user();
        $warehouses = $user->warehouses;

        // Retrieve the warehouse that needs to be loaded with slots and load the slots if it exists
        $warehouseToBeLoaded = $warehouses
            ->where('number', $warehouseNumber)
            ->first();
        if($warehouseToBeLoaded !== null) {
            $warehouseToBeLoaded->loadMissing('slots');
        }

        return response($warehouses);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }
}
