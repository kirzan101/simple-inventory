<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignFormRequest;
use App\Interfaces\AssignInterface;
use App\Models\Assign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignController extends Controller
{
    public function __construct(private AssignInterface $assign)
    {
        $this->assign = $assign;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        ['results' => $assigns, 'rows' => $rows, 'inventories' => $inventories, 'employees' => $employees] = $this->assign->indexAssign($request->toArray());
        // return response()->json([
        //     'assigns' => $assigns,
        //     'message' => 'success',
        // ]);
        return Inertia::render('Assign/IndexAssign', [
            'assigns' => $assigns->all(),
            'inventories' => $inventories->all(),
            'employees' => $employees->all(),
            'rows' => $rows,
            'meta' => $assigns->resource,
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
    public function store(AssignFormRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Assign $assigns)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assign $assigns)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assign $assigns)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assign $assigns)
    {
        //
    }
}
