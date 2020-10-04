<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $itemList = request()->user()->todaysList();
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
        $itemList = request()->user()->todaysList();
        $item = $itemList->items()->create([
            'body' => $data['body'],
            'user_id' => auth()->id(),
        ]);
        return response()->json([
            'item' => $item
        ]);
    }
}
