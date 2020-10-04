<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class CompleteItemController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Item $item)
    {
        abort_if(request()->user()->cant('view', $item->itemList), 403);
        $item->complete();
        return response()->json([
            'item' => $item,
        ]);
    }
}
