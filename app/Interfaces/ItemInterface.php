<?php

namespace App\Interfaces;

interface ItemInterface
{
    public function indexItem(array $request): array;
    public function createItem(array $request): array;
    public function editItem(array $request, int $item_id): array;
    public function deleteItem(int $item_id): array;
    public function showItem(int $item_id): array;
}
