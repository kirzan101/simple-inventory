<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeFormRequest;
use App\Interfaces\EmployeeInterface;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        ['results' => $employees, 'rows' => $rows] = $this->employee->indexEmployee($request->toArray());
        return response()->json([
            'employees' => $employees,
            'message' => 'success',
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
    public function store(Request $request)
    {
        ['result' => $employee, 'message' => $message] = $this->employee->createEmployee($request->toArray());

        return response()->json([
            'employee' => $employee,
            'message' => $message,
        ]);
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
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
