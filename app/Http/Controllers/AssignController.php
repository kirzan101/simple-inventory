<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignFormRequest;
use App\Interfaces\AssignInterface;
use App\Interfaces\EmployeeInterface;
use App\Interfaces\InventoryInterface;
use App\Models\Assign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssignController extends Controller
{
    public function __construct(private AssignInterface $assign, private InventoryInterface $inventory, private EmployeeInterface $employee)
    {
        $this->assign = $assign;
        $this->inventory = $inventory;
        $this->employee = $employee;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        ['results' => $assigns] = $this->assign->indexPaginateAssign($request->toArray());
        ['results' => $inventories] = $this->inventory->indexInventory();
        ['results' => $employees] = $this->employee->indexEmployee();
        // return response()->json([
        //     'assigns' => $assigns,
        //     'message' => 'success',
        // ]);
        return Inertia::render('Assign/IndexAssign', [
            'assigns' => $assigns->all(),
            'inventories' => $inventories->all(),
            'employees' => $employees->all(),
            'per_page' => $assigns->perPage(),
            'current_page' => $assigns->currentPage(),
            'page' => ($request['page']) ? $request['page'] : 1,
            'total' => $assigns->total(),
            'last_page' => $assigns->lastPage(),
            'search' => $request['search'],
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
        ['result' => $assigns, 'message' => $message] = $this->assign->createAssign($request->toArray());

        return redirect()->back()->with('message', $message);
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
    public function update(Request $request, Assign $assign)
    {
        ['result' => $assign, 'message' => $message] = $this->assign->editAssign($request->toArray(), $assign->id);
        //
        return redirect()->back()->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assign $assigns)
    {
        //
    }
}
