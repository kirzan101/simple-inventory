<?php

namespace App\Interfaces;

interface InventoryInterface
{
    public function indexInventory(): array;
    public function indexPaginateInventory(array $request): array;
    public function createInventory(array $request): array;
    public function editInventory(array $request, int $inventory_id): array;
    public function deleteInventory(int $inventory_id): array;
    public function showInventory(int $inventory_id): array;
}