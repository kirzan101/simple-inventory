<?php

namespace App\Http\Controllers;

use App\Interfaces\InventoryInterface;
use App\Models\Inventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    public function __construct(private InventoryInterface $inventory)
    {
        $this->inventory = $inventory;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        ['results' => $inventories] = $this->inventory->indexInventory($request->toArray());

        return Inertia::render('Inventory/IndexInventory', [
            'inventory' => $inventories->all(),
            'meta' => $inventories->resource
        ]);
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
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
