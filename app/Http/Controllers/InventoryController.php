<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryFormRequest;
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
        ['results' => $inventories, 'rows' => $rows] = $this->inventory->indexInventory($request->toArray());

        // return response()->json([
        //     'inventories' => $inventories,
        //     'message' => 'success'
        // ]);
        return Inertia::render('Inventory/IndexInventory', [
            'inventories' => $inventories->all(),
            'rows' => $rows,
            'meta' => $inventories->resource,
        ]); // Compact
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
    public function store(InventoryFormRequest $request)
    {
        ['result' => $inventory, 'message' => $message] = $this->inventory->createInventory($request->toArray());

        // return response()->json([
        //     'inventory' => $inventory,
        //     'message' => 'success',
        // ]);

        return redirect()->back()->with('message', $message);
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
    public function update(InventoryFormRequest $request, Inventory $inventory)
    {
        ['result' => $inventory, 'message' => $message] = $this->inventory->editInventory($request->toArray(), $inventory->id);

        // return response()->json([
        //     'items' => $inventory,
        //     'message' => 'success',
        // ]);
        return redirect()->back()->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
