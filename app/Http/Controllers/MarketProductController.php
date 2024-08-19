<?php

namespace App\Http\Controllers;

use App\Models\MarketProduct;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class MarketProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return ['auth:sanctum'];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MarketProduct $marketProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarketProduct $marketProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MarketProduct $marketProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketProduct $marketProduct)
    {
        //
    }
}
