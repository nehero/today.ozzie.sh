<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $user = request()->user();
        $nowInTheirTimezone = Carbon::parse('now', $user->timezone);
        $itemList = $user->itemLists()->whereDate('created_at', $nowInTheirTimezone->clone()->setTimezone('UTC'))->firstOrCreate([], ['name' => $nowInTheirTimezone->format('Y-m-d')]);
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
        $user = request()->user();
        $nowInTheirTimezone = Carbon::parse('now', $user->timezone);
        $itemList = $user->itemLists()->whereDate('created_at', $nowInTheirTimezone->clone()->setTimezone('UTC'))->firstOrCreate([], ['name' => $nowInTheirTimezone->format('Y-m-d')]);
        $item = $itemList->items()->create([
            'body' => $data['body'],
            'user_id' => auth()->id(),
        ]);
        return response()->json([
            'item' => $item
        ]);
    }
}
