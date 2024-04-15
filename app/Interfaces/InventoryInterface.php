<?php

namespace App\Interfaces;

interface InventoryInterface
{
    public function indexInventory(array $request): array;
    public function createInventory(array $request): array;
    public function editInventory(array $request): array;
    public function deleteInventory(array $request): array;
    public function showInventory(array $request): array;
}