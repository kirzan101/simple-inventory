<?php

namespace App\Services;

use App\Http\Resources\ItemResource;
use App\Interfaces\ItemInterface;
use App\Models\Item;
use App\Traits\ReturnCollectionTrait;
use App\Traits\ReturnModelTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class ItemService implements ItemInterface
{
    use ReturnCollectionTrait, ReturnModelTrait;
    public $return_result = [];

    public function indexItem(): array
    {
        $items = Item::all();

        $this->return_result = $this->returnCollection(200, 'success', 'successfully retrieved', ItemResource::collection($items));

        return $this->return_result;
    }
    public function indexPaginateItem(array $request): array
    {
        // page defaults
        $per_page = (array_key_exists('per_page', $request) && $request['per_page']) ? $request['per_page'] : 10;
        $sort = (array_key_exists('orderByDesc', $request) && $request['orderByDesc']) ? 'desc' : 'asc';
        $sort_by = (array_key_exists('sortBy', $request) && $request['sortBy']) ? $request['sortBy'] : 'id';

        $items = Item::query();

        if (array_key_exists('search', $request) && !empty($request['search'])) {
            $items = $items->where('name', 'LIKE', '%' . $request['search'] . '%');
        }

        $items = $items->orderBy($sort_by, $sort)->paginate($per_page);

        $this->return_result = $this->returnCollection(200, 'success', 'successfully retrieved', ItemResource::collection($items));

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
