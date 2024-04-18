<?php

namespace App\Traits;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

trait ReturnCollectionTrait
{
    public function returnCollection(mixed $code = null, ?string $status = null, ?string $message = null, AnonymousResourceCollection $results = null): array 
    {
        //
        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'results' => $results
        ];
    }
}
