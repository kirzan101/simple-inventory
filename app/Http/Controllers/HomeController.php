<?php

namespace App\Http\Controllers;

use App\Interfaces\ItemInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct(private ItemInterface $item)
    {
        $this->item = $item;
    }

    public function index(Request $request)
    {
        ['results' => $items] = $this->item->indexItem($request->toArray());
        // $results = $this->item->indexItem($request->toArray());
        // $results['results'];

        return Inertia::render('Home/IndexHome', [
            'items' => $items->all()
        ]);
    }
}
