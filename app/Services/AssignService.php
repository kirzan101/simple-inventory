<?php

namespace App\Services;

use App\Http\Resources\AssignResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\InventoryResource;
use App\Interfaces\AssignInterface;
use App\Models\Assign;
use App\Models\Employee;
use App\Models\Inventory;
use App\Traits\ReturnCollectionTrait;
use App\Traits\ReturnModelTrait;
use Exception;
use Illuminate\Support\Facades\DB;


class AssignService implements AssignInterface
{
    use ReturnCollectionTrait, ReturnModelTrait;
    public $return_result = [];

    public function indexAssign(): array
    {
        $assigns = Assign::all();

        $this->return_result = $this->returnCollection(200, 'success', 'succesfully retrieved', AssignResource::collection($assigns));

        return $this->return_result;
    }
    public function indexPaginateAssign(array $request): array
    {
        $per_page = (array_key_exists('per_page', $request) && $request['per_page']) ? $request['per_page'] : 10;
        $sort = (array_key_exists('orderByDesc', $request) && $request['orderByDesc']) ? 'desc' : 'asc';
        $sort_by = (array_key_exists('sortBy', $request) && $request['sortBy']) ? $request['sortBy'] : 'id';

        $assigns = Assign::query();

        // $assigns = Assign::paginate($per_page);
        // $inventories = Inventory::all();
        // $employees = Employee::all();

        // search filter
        if (array_key_exists('search', $request) && !empty($request['search'])) {
            $assigns->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request['search'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $request['search'] . '%')
                    ->orWhere('employee_id', 'LIKE', '%' . $request['search'] . '%')
                    ->orWhere('inventory_id', 'LIKE', '%' . $request['search'] . '%')
                    ->orWhere('assigned_by', 'LIKE', '%' . $request['search'] . '%');
            });
        }

        $assigns = $assigns->orderBy($sort_by, $sort)->paginate($per_page);

        $this->return_result = $this->returnCollection(200, 'success', 'successfully retrieved', AssignResource::collection($assigns));
        // 'results' => AssignResource::collection($assigns),
        // 'inventories' => InventoryResource::collection($inventories),
        // 'employees' => EmployeeResource::collection($employees),

        return $this->return_result;
    }
    public function createAssign(array $request): array
    {
        try {
            DB::beginTransaction();

            $assign = Assign::create([
                'name' => $request['name'],
                'description' => $request['description'],
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
                'description' => $request['description'],
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
        try {
            $assign = Assign::findOrFail($assign_id);
            $this->return_result = [
                'message' => 'success',
                'code' => '200',
                'result' => $assign
            ];
        } catch (Exception $e) {
            $this->return_result = [
                'message' => $e->getMessage(),
                'code' => '500'
            ];
        }
        return $this->return_result;
    }


}