<?php

namespace App\Services;

use App\Http\Resources\InventoryResource;
use App\Http\Resources\ItemResource;
use App\Interfaces\InventoryInterface;
use App\Models\Inventory;
use App\Models\Item;
use App\Traits\ReturnCollectionTrait;
use App\Traits\ReturnModelTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class InventoryService implements InventoryInterface
{
    use ReturnCollectionTrait, ReturnModelTrait;
    public $return_result = [];

    public function indexInventory(): array
    {
        $inventories = Inventory::all();

        $this->return_result = $this->returnCollection(200, 'success', 'succesfully retrieved', InventoryResource::collection($inventories));

        return $this->return_result;
    }
    public function indexPaginateInventory(array $request): array
    {
        $per_page = (array_key_exists('per_page', $request) && $request['per_page']) ? $request['per_page'] : 10;
        $sort = (array_key_exists('orderByDesc', $request) && $request['orderByDesc']) ? 'desc' : 'asc';
        $sort_by = (array_key_exists('sortBy', $request) && $request['sortBy']) ? $request['sortBy'] : 'id';

        $inventories = Inventory::query();

        // search filter
        if (array_key_exists('search', $request) && !empty($request['search'])) {
            $inventories->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request['search'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $request['search'] . '%')
                    ->orWhere('batch_number', 'LIKE', '%' . $request['search'] . '%')
                    ->orWhere('serial_number', 'LIKE', '%' . $request['search'] . '%')
                    ->orWhere('item_id', 'LIKE', '%' . $request['search'] . '%');
            });
        }

        $inventories = $inventories->orderBy($sort_by, $sort)->paginate($per_page);

        $this->return_result = $this->returnCollection(200, 'success', 'successfully retrieved', InventoryResource::collection($inventories));

        return $this->return_result;
    }

    public function createInventory(array $request): array
    {
        try {
            DB::beginTransaction();

            $inventory = Inventory::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'batch_number' => $request['batch_number'],
                'serial_number' => $request['serial_number'],
                'item_id' => $request['item_id'],
            ]);

            $this->return_result = [
                'message' => 'success',
                'code' => '201',
                'result' => new InventoryResource($inventory)
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

    public function editInventory(array $request, int $inventory_id): array
    {
        try {
            DB::beginTransaction();
            $inventory = Inventory::findOrFail($inventory_id);

            $inventory->update([
                'name' => $request['name'],
                'description' => $request['description'],
                'batch_number' => $request['batch_number'],
                'serial_number' => $request['serial_number'],
                'item_id' => $request['item_id'],
            ]);

            $this->return_result = [
                'message' => 'success',
                'code' => '202',
                'result' => new InventoryResource($inventory)
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

    public function deleteInventory(int $inventory_id): array
    {
        try {
            DB::beginTransaction();
            $item = Inventory::findOrFail($inventory_id);

            $item->delete();

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

    public function showInventory(int $inventory_id): array
    {
        try {
            $item = Inventory::findOrFail($inventory_id);

            $this->return_result = [
                'message' => 'success',
                'code' => '200',
                'result' => $inventory_id
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
