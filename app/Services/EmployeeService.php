<?php

namespace App\Services;

use App\Http\Resources\EmployeeResource;
use App\Interfaces\EmployeeInterface;
use App\Models\Employee;
use Exception;
use Illuminate\Support\Facades\DB;

class EmployeeService implements EmployeeInterface
{
    public $return_result = [];

    public function indexEmployee(array $request): array
    {
        $per_page = 10;
        $orderByDesc = true;

        $employee = Employee::paginate($per_page);
        $rows = $employee->total();

        $this->return_result = [
            'message' => 'success',
            'code' => '200',
            'results' => EmployeeResource::collection($employee),
            'rows' => $rows
        ];

        return $this->return_result;
    }

    public function createEmployee(array $request): array
    {
        try {
            DB::beginTransaction();

            $employee = Employee::create([
                'name' => $request['name'],
                'position' => $request['position'],
                'department' => $request['department'],
                'branch' => $request['branch'],
            ]);

            $this->return_result = [
                'message' => 'success',
                'code' => '201',
                'result' => new EmployeeResource($employee),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $this->return_result = [
                'message' => $e->getMessage(),
                'code' => 500,
            ];
        }
        DB::commit();

        return $this->return_result;
    }

    public function editEmployee(array $request, int $employee_id): array
    {
        try {
            DB::beginTransaction();
            $employee = Employee::findOrFail($employee_id);

            $employee->update([
                'name' => $request['name'],
                'position' => $request['position'],
                'department' => $request['deparment'],
                'branch' => $request['branch'],
            ]);
            $this->return_result = [
                'message' => 'success',
                'code' => '202',
                'result' => new EmployeeResource($employee)
            ];
        } catch (Exception $e) {
            DB::rollBack();

            $this->return_result = [
                'message' => $e->getMessage(),
                'code' => 500,
            ];
        }
        DB::commit();

        return $this->return_result;
    }

    public function deleteEmployee(array $request): array
    {
        return $this->return_result;
    }

    public function showEmployee(array $request): array
    {
        return $this->return_result;
    }
}