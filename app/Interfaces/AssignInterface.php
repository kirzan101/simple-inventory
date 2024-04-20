<?php

namespace App\Interfaces;

interface AssignInterface
{
    public function indexAssign(): array;
    public function indexPaginateAssign(array $request): array;
    public function createAssign(array $request): array;

    public function editAssign(array $request, int $assign_id): array;

    public function deleteAssign(int $assign_id): array;

    public function showAssign(int $assign_id): array;
}