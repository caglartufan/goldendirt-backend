<?php

namespace App\Http\Controllers;

use App\Models\MarketProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MarketProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return ['auth:sanctum'];
    }

    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $marketProducts = MarketProduct::with('marketable')->get();

        return response($marketProducts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function buy(Request $request, MarketProduct $marketProduct)
    {
        // Check if query parameter named 'quantity' exists and is an integer value
        // if so, assign the integer value of query parameter to $quantity
        $validator = Validator::make($request->query(), [
            'quantity' => 'integer|required'
        ]);

        // Default quantity is 1
        $quantity = $validator->passes()
            ? (int)$request->query('quantity')
            : 1;
        
        // Check if user has enough golds to make the purchase
        $user = $request->user();
        $total = $quantity * $marketProduct->price;

        if($user->golds < $total) {
            return abort(403, __('messages.insufficient_golds'));
        }

        // Find user's warehouse slot occupied by the marketable (the product itself such as Seed)
        $occupiedWarehouseSlot = $this->retrieveOccupiedWarehouseSlotOfUserOrAbort($user, $marketProduct);

        // Update user's amount of golds, occupied warehouse slot's quantity and then
        // save both user and occupied warehouse slot
        DB::transaction(function() use($user, $occupiedWarehouseSlot, $total, $quantity) {
            $user->golds -= $total;
            $occupiedWarehouseSlot->quantity += $quantity;
            $user->save();
            $occupiedWarehouseSlot->save();
        });

        return response([
            'market_product' => $marketProduct,
            'quantity' => $quantity,
            'total' => $total,
            'slot' => $occupiedWarehouseSlot
        ]);
    }

    private function retrieveOccupiedWarehouseSlotOfUserOrAbort(User $user, MarketProduct $marketProduct) {
        $marketable = $marketProduct->marketable;
        $occupiedWarehouseSlot = $user->warehouseSlots()->where([
            ['storable_id', $marketable->id],
            ['storable_type', $marketProduct->marketable_type]
        ])->first();

        if($occupiedWarehouseSlot) {
            return $occupiedWarehouseSlot;
        }

        $unoccupiedWarehouseSlot = $user
            ->warehouseSlots()
            ->whereNull(['storable_id', 'storable_type'])
            ->orderBy('id', 'asc')
            ->first();

        if(!$unoccupiedWarehouseSlot) {
            return abort(409, __('messages.not_enough_space_in_warehouses'));
        }

        $unoccupiedWarehouseSlot->storable()->associate($marketable);
        $unoccupiedWarehouseSlot->quantity = 0;
        
        return $unoccupiedWarehouseSlot;
    }
}
