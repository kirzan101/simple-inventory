<?php

namespace App\Services;

use App\Http\Resources\InventoryResource;
use App\Http\Resources\ItemResource;
use App\Interfaces\InventoryInterface;
use App\Models\Inventory;
use App\Models\Item;
use Exception;
use Illuminate\Support\Facades\DB;

class InventoryService implements InventoryInterface
{
    public $return_result = [];

    public function indexInventory(): array
    {
        $inventories = Inventory::all();

        $per_page = 10;
        $orderByDesc = true;
        $items = Item::all();
        $inventories = Inventory::paginate($per_page);
        $rows = $inventories->total();

        $this->return_result = [
            'message' => 'success',
            'code' => '200',
            'results' => InventoryResource::collection($inventories),
            'items' => ItemResource::collection($items),
            'rows' => $rows
        ];

        return $this->return_result;
    }
    public function indexPaginateInventory(array $request): array
    {
        $per_page = 10;
        $orderByDesc = true;
        $items = Item::all();
        $inventories = Inventory::paginate($per_page);
        $rows = $inventories->total();

        $this->return_result = [
            'message' => 'success',
            'code' => '200',
            'results' => InventoryResource::collection($inventories),
            'items' => ItemResource::collection($items),
            'rows' => $rows
        ];

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
