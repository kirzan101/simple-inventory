<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeFormRequest;
use App\Interfaces\EmployeeInterface;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeInterface $employee)
    {
        $this->employee = $employee;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        ['results' => $employees] = $this->employee->indexPaginateEmployee($request->toArray());
// dd($request->current_page);
        return Inertia::render('Employee/IndexEmployee', [
            'employees' => $employees->all(),
            'per_page' => $employees->perPage(),
            'current_page' => $employees->currentPage(),
            'page' => ($request['page']) ? $request['page'] : 1,
            'total' => $employees->total(),
            'last_page' => $employees->lastPage(),
            'search' => $request['search'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(EmployeeFormRequest $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeFormRequest $request)
    {
        ['result' => $employee, 'message' => $message] = $this->employee->createEmployee($request->toArray());

        // return response()->json([
        //     'employee' => $employee,
        //     'message' => $message,
        // ]);
        return redirect()->back()->with('message', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeFormRequest $request, Employee $employee)
    {
        ['result' => $employee, 'message' => $message] = $this->employee->editEmployee($request->toArray(), $employee->id);

        return response()->json([
            'employees' => $employee,
            'message' => 'success',
        ]);

        // return redirect()->back()->with('message', $message);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
