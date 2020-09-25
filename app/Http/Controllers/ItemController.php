<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $itemList = request()->user()->itemLists()->whereDate('created_at', now())->firstOrCreate([], ['name' => now()->format('Y-m-d')]);
        return response()->json([
            'item_list' => $itemList,
            'items' => $itemList->items,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'body' => ['required', 'string'],
        ]);
        $itemList = request()->user()->itemLists()->whereDate('created_at', now())->firstOrCreate([], ['name' => now()->format('Y-m-d')]);
        $item = $itemList->items()->create([
            'body' => $data['body'],
            'user_id' => auth()->id(),
        ]);
        return response()->json([
            'item' => $item
        ]);
    }
}
