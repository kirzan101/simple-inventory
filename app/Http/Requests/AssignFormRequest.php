<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'employee_id' => 'required',
            'inventory_id' => 'required',
            'assigned_by' => 'required',
        ];
    }
}