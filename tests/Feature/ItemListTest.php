<?php

namespace Tests\Feature;

use App\Models\ItemList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_itemlist_in_users_timezone_even_if_utc_is_on_next_day()
    {
        Carbon::setTestNow(Carbon::parse('2020-01-05 01:00:00', 'UTC'));
        $user = User::factory()->create([
            'timezone' => 'America/Regina',
        ]);
        $response = $this->actingAs($user)->json('GET', 'api/items');
        $response->assertStatus(200);
        $response->assertJson([
            'item_list' => [
                'name' => '2020-01-04',
            ],
            'items' => [],
        ]);
    }
    
    public function test_it_reuses_itemlist_if_created_in_same_day_in_users_timezone_but_two_days_utc_time()
    {
        Carbon::setTestNow(Carbon::parse('2020-01-04 10:00:00', 'UTC'));
        $user = User::factory()->create([
            'timezone' => 'America/Regina',
        ]);
        $response = $this->actingAs($user)->json('GET', 'api/items');
        $response->assertStatus(200);
        $response->assertJson([
            'item_list' => [
                'name' => '2020-01-04',
            ],
            'items' => [],
        ]);
        $itemList = ItemList::first();
        Carbon::setTestNow(Carbon::parse('2020-01-05 01:00:00', 'UTC'));
        $response = $this->actingAs($user)->json('GET', 'api/items');
        $response->assertStatus(200);
        $response->assertJson([
            'item_list' => [
                'id' => $itemList->id,
                'name' => '2020-01-04',
            ],
            'items' => [],
        ]);
    }
    
    public function test_it_creates_items_in_proper_list_using_users_timezone_even_if_utc_is_on_next_day()
    {
        Carbon::setTestNow(Carbon::parse('2020-01-05 01:00:00', 'UTC'));
        $user = User::factory()->create([
            'timezone' => 'America/Regina',
        ]);
        $response = $this->actingAs($user)->json('POST', 'api/items', [
            'body' => 'get groceries'
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'item' => [
                'body' => 'get groceries'
            ],
        ]);
        $this->assertSame(ItemList::first()->name, '2020-01-04');
    }
}
