<?php

namespace App\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

trait ReturnModelTrait
{
    public function returnModel(mixed $code = null, ?string $status = null, ?string $message = null, ?int $last_id = null, JsonResource $result = null): array
    {
        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'result' => $result
        ];
    }
}
