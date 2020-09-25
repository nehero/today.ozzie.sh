<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function itemList()
    {
        return $this->belongsTo(ItemList::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
