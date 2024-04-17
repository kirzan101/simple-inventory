<?php

namespace App\Interfaces;

interface EmployeeInterface
{
    public function indexEmployee(array $request): array;
    public function createEmployee(array $request): array;
    public function editEmployee(array $request, int $employee_id): array;
    public function deleteEmployee(array $request): array;
    public function showEmployee(array $request): array;
}