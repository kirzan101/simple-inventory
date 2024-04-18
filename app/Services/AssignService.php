<?php

namespace App\Services;

use App\Http\Resources\AssignResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\InventoryResource;
use App\Interfaces\AssignInterface;
use App\Models\Assign;
use App\Models\Employee;
use App\Models\Inventory;
use Exception;
use Illuminate\Support\Facades\DB;


class AssignService implements AssignInterface
{
    public $return_result = [];

    public function indexAssign(array $request): array
    {
        $per_page = 10;
        $orderByDesc = true;
        $assigns = Assign::paginate($per_page);
        $inventories = Inventory::all();
        $employees = Employee::all();
        $rows = $assigns->total();

        $this->return_result = [
            'message' => 'success',
            'code' => '200',
            'results' => AssignResource::collection($assigns),
            'inventories' => InventoryResource::collection($inventories),
            'employees' => EmployeeResource::collection($employees),
            'rows' => $rows
        ];

        return $this->return_result;
    }
    public function createAssign(array $request): array
    {
        try {
            DB::beginTransaction();

            $assign = Assign::create([
                'name' => $request['name'],
                'employee_id' => $request['employee_id'],
                'inventory_id' => $request['inventory_id'],
                'assigned_by' => $request['assigned_by'],
            ]);

            $this->return_result = [
                'message' => 'success',
                'code' => '201',
                'result' => new AssignResource($assign)
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
    public function editAssign(array $request, int $assign_id): array
    {
        try {
            DB::beginTransaction();
            $assign = Assign::findOrFail($assign_id);

            $assign->update([
                'name' => $request['name'],
                'employee_id' => $request['employee_id'],
                'inventory_id' => $request['inventory_id'],
                'assigned_by' => $request['assigned_by'],
            ]);
            $this->return_result = [
                'message' => 'success',
                'code' => '202',
                'result' => new AssignResource($assign)
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
    public function deleteAssign(int $assign_id): array
    {
        try {
            DB::beginTransaction();
            $assign = Assign::findOrFail($assign_id);

            $assign->delete();

            $this->return_result = [
                'message' => 'success',
                'code' => '200',
            ];
        } catch (Exception $e) {
            DB::rollBack();

            $this->return_result = [
                'message' => $e->getMessage(),
                'code' => '500'
            ];
        }
        DB::commit();

        return $this->return_result;
    }
    public function showAssign(int $assign_id): array
    {
        return $this->return_result;
    }


}