<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'employee_id' => $this->employee_id,
            'inventory_id' => $this->inventory_id,
            'assigned_by' => $this->assigned_by,
            'id' => $this->id,
        ];
    }
}