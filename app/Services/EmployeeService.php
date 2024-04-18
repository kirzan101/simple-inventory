<?php

namespace App\Services;

use App\Http\Resources\EmployeeResource;
use App\Interfaces\EmployeeInterface;
use App\Models\Employee;
use App\Traits\ReturnCollectionTrait;
use App\Traits\ReturnModelTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class EmployeeService implements EmployeeInterface
{
    use ReturnCollectionTrait, ReturnModelTrait;

    public $return_result = [];

    public function indexEmployee(): array
    {
        $employees = Employee::all();

        $this->return_result = $this->returnCollection(200, 'success', 'successfully retrieved', EmployeeResource::collection($employees));

        return $this->return_result;
    }

    public function indexPaginateEmployee(array $request): array
    {
        // srat defaults
        $per_page = (array_key_exists('per_page', $request) &&$request['per_page']) ? $request['per_page'] : 10;
        $sort = (array_key_exists('orderByDesc', $request) && $request['orderByDesc']) ? 'desc' : 'asc';
        $sort_by = (array_key_exists('sortBy', $request) && $request['sortBy']) ? $request['sortBy'] : 'id';

        $employees = Employee::query();

        if (array_key_exists('search', $request) && !empty($request['search'])) {
            $employees = $employees->where('name', 'LIKE', '%' . $request['search'] . '%');
        }

        // search filter
        // if (array_key_exists('search', $request) && !empty($request['search'])) {
        //     $employees->where(function ($query) use ($request) {
        //         $query->where('first_name', 'LIKE', '%' . $request['search'] . '%')
        //             ->orWhere('middle_name', 'LIKE', '%' . $request['search'] . '%')
        //             ->orWhere('last_name', 'LIKE', '%' . $request['search'] . '%');
        //     });
        // }

        $employees = $employees->orderBy($sort_by, $sort)->paginate($per_page);
        
        $this->return_result = $this->returnCollection(200, 'success', 'successfully retrieved', EmployeeResource::collection($employees));

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

    public function deleteEmployee(int $employee_id): array
    {
        try {
            DB::beginTransaction();
            $employee = Employee::findOrFail($employee_id);
            $employee->delete();

            $this->return_result = [
                'message' => 'success',
                'code' => 200,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            $this->return_result = [
                'message' => $e->getMessage(),
                'code' => 500
            ];
        }
        DB::commit();

        return $this->return_result;
    }

    public function showEmployee(int $employee_id): array
    {
        return $this->return_result;
    }
}
