<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemFormRequest;
use App\Interfaces\ItemInterface;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function __construct(private ItemInterface $item)
    {
        $this->item = $item;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        ['results' => $items, 'rows' => $rows] = $this->item->indexItem($request->toArray());

        // return response()->json([
        //     'items' => $items,
        //     'message' => 'success',
        // ]);

        return Inertia::render('Item/IndexItem', [
            'items' => $items->all(),
            'rows' => $rows,
            'meta' => $items->resource,
        ]); //compact
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
    public function store(ItemFormRequest $request)
    {
        ['result' => $item, 'message' => $message] = $this->item->createItem($request->toArray());

        // return response()->json([
        //     'items' => $item,
        //     'message' => 'success',
        // ]);

        return redirect()->back()->with('message', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemFormRequest $request, Item $item)
    {
        ['result' => $item, 'message' => $message] = $this->item->editItem($request->toArray(), $item->id);

        // return response()->json([
        //     'items' => $item,
        //     'message' => 'success',
        // ]);
        return redirect()->back()->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
