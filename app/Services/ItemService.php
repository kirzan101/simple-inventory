<?php

namespace App\Services;

use App\Http\Resources\ItemResource;
use App\Interfaces\ItemInterface;
use App\Models\Item;
use Exception;
use Illuminate\Support\Facades\DB;

class ItemService implements ItemInterface
{
    public $return_result = [];

    public function indexItem(array $request): array
    {
        $per_page = 10;
        $orderByDesc = true;

        $items = Item::paginate($per_page);
        // $rows = Item::all()->count();
        $rows = $items->total();

        $this->return_result = [
            'message' => 'success',
            'code' => '200',
            'results' => ItemResource::collection($items),
            'rows' => $rows
        ];

        return $this->return_result;
    }

    public function createItem(array $request): array
    {
        try {
            DB::beginTransaction();

            $item = Item::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'model' => $request['model'],
                'brand' => $request['brand'],
            ]);

            $this->return_result = [
                'message' => 'success',
                'code' => '201',
                'result' => new ItemResource($item)
            ];
        } catch (Exception $e) {
            DB::rollBack();

            $this->return_result = [
                'message' => $e->getMessage(),
                'code' => '500'
            ];
        }
        DB::commit();

        return $this->return_result;
    }

    public function editItem(array $request, int $item_id): array
    {
        try {
            DB::beginTransaction();
            $item = Item::findOrFail($item_id);

            $item->update([
                'name' => $request['name'],
                'description' => $request['description'],
                'model' => $request['model'],
                'brand' => $request['brand'],
            ]);

            $this->return_result = [
                'message' => 'success',
                'code' => '200',
                'result' => new ItemResource($item)
            ];
        } catch (Exception $e) {
            DB::rollBack();

            $this->return_result = [
                'message' => $e->getMessage(),
                'code' => '500'
            ];
        }
        DB::commit();

        return $this->return_result;
    }

    public function deleteItem(int $item_id): array
    {
        try {
            DB::beginTransaction();
            $item = Item::findOrFail($item_id);

            $item->delete();

            $this->return_result = [
                'message' => 'success',
                'code' => '200',
            ];
        } catch (Exception $e) {
            DB::rollBack();

            $this->return_result = [
                'message' => $e->getMessage(),
                'code' => '500'
            ];
        }
        DB::commit();

        return $this->return_result;
    }

    public function showItem(int $item_id): array
    {
        try {
            $item = Item::findOrFail($item_id);

            $this->return_result = [
                'message' => 'success',
                'code' => '200',
                'result' => $item
            ];
        } catch (Exception $e) {
            $this->return_result = [
                'message' => $e->getMessage(),
                'code' => '500'
            ];
        }

        return $this->return_result;
    }
}
