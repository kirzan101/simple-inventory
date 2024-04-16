<?php

namespace App\Services;

use App\Http\Resources\InventoryResource;
use App\Interfaces\InventoryInterface;
use App\Models\Inventory;

class InventoryService implements InventoryInterface
{
    public $return_result = [];

    public function indexInventory(array $request): array
    {
        $per_page = 10;
        $orderByDesc = true;

        $inventory = Inventory::paginate($per_page);

        $this->return_result = [
            'message' => 'success',
            'code' => '200',
            'results' => InventoryResource::collection($inventory)
        ];

        return $this->return_result;
    }

    public function createInventory(array $request): array
    {
        return $this->return_result;
    }

    public function editInventory(array $request): array
    {
        return $this->return_result;
    }

    public function deleteInventory(array $request): array
    {
        return $this->return_result;
    }

    public function showInventory(array $request): array
    {
        return $this->return_result;
    }

}
