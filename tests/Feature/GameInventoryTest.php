<?php

namespace Tests\Feature;

use App\Models\Catalog;
use App\Models\Item;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameInventoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_user_can_login_and_view_dashboard(): void
    {
        $response = $this->post('/username', ['name' => 'Арагорн']);
        $response->assertRedirect('/');

        $user = User::where('name', 'Арагорн')->first();
        $this->assertNotNull($user);

        $dashResponse = $this->withSession(['user_id' => $user->id])->get('/');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Арагорн');
    }

    public function test_user_cannot_mine_gold_without_tool(): void
    {
        $user = User::firstOrCreate(['name' => 'БезКирки']);

        $mineResp = $this->withSession(['user_id' => $user->id])->post('/mine');
        $mineResp->assertSessionHas('error');

        // Coins should remain unchanged
        $this->assertEquals(100, $user->fresh()->coins);
    }

    public function test_user_can_gather_resources_and_mine_gold_with_pickaxe(): void
    {
        $user = User::firstOrCreate(['name' => 'Шахтёр']);

        // Gather resource
        $gatherResp = $this->withSession(['user_id' => $user->id])->post('/gather');
        $gatherResp->assertRedirect();
        $this->assertGreaterThan(0, $user->items()->count());

        // Give user a stone pickaxe
        $pickaxe = Catalog::where('name', 'Каменная кирка')->first();
        $user->items()->create(['catalog_id' => $pickaxe->id]);

        $initialCoins = $user->coins;
        $mineResp = $this->withSession(['user_id' => $user->id])->post('/mine');
        $mineResp->assertSessionHas('success');
        $user->refresh();
        $this->assertGreaterThan($initialCoins, $user->coins);
    }

    public function test_user_can_forge_weapon_and_delete_it(): void
    {
        $user = User::firstOrCreate(['name' => 'Кузнец']);

        // Forge weapon
        $forgeResp = $this->withSession(['user_id' => $user->id])->post('/inventory', [
            'title' => 'Эльфийский лук',
            'description' => 'Создан в Ривенделле',
            'power' => 85,
        ]);
        $forgeResp->assertRedirect('/inventory/list');

        $item = $user->items()->with('catalog')->whereHas('catalog', fn($q) => $q->where('name', 'Эльфийский лук'))->first();
        $this->assertNotNull($item);
        $this->assertEquals('Эльфийский лук', $item->title);
        $this->assertEquals(85, $item->power);

        // List
        $listResp = $this->withSession(['user_id' => $user->id])->get('/inventory/list');
        $listResp->assertStatus(200);
        $listResp->assertSee('Эльфийский лук');

        // Show
        $showResp = $this->withSession(['user_id' => $user->id])->get('/inventory/' . $item->id);
        $showResp->assertStatus(200);
        $showResp->assertSee('Эльфийский лук');

        // Delete
        $delResp = $this->withSession(['user_id' => $user->id])->delete('/inventory/' . $item->id);
        $delResp->assertRedirect('/inventory/list');
        $this->assertNull(Item::find($item->id));
    }

    public function test_user_can_craft_tool_from_recipe(): void
    {
        $user = User::firstOrCreate(['name' => 'Крафтер']);

        $wood = Catalog::where('name', 'Дерево')->first();
        $stone = Catalog::where('name', 'Камень')->first();
        $pickaxe = Catalog::where('name', 'Каменная кирка')->first();

        // 2 wood + 3 stone
        for ($i = 0; $i < 2; $i++) {
            $user->items()->create(['catalog_id' => $wood->id]);
        }
        for ($i = 0; $i < 3; $i++) {
            $user->items()->create(['catalog_id' => $stone->id]);
        }

        $craftResp = $this->withSession(['user_id' => $user->id])->post('/inventory/craft/' . $pickaxe->id);
        $craftResp->assertRedirect('/inventory/list');

        $this->assertTrue($user->items()->where('catalog_id', $pickaxe->id)->exists());
    }

    public function test_user_can_buy_from_shop_and_sell_to_merchant(): void
    {
        $user = User::firstOrCreate(['name' => 'Купец'], ['coins' => 250]);

        $sword = Catalog::where('name', 'Стальной меч')->first();

        // View shop
        $shopResp = $this->withSession(['user_id' => $user->id])->get('/shop');
        $shopResp->assertStatus(200);
        $shopResp->assertSee('Стальной меч');

        // Buy sword (costs 160)
        $buyResp = $this->withSession(['user_id' => $user->id])->post('/shop/buy/' . $sword->id);
        $buyResp->assertSessionHas('success');
        $user->refresh();
        $this->assertEquals(250 - 160, $user->coins);
        $this->assertTrue($user->items()->where('catalog_id', $sword->id)->exists());

        // Sell sword
        $boughtItem = $user->items()->where('catalog_id', $sword->id)->first();
        $sellPrice = $boughtItem->sell_price;
        $coinsBeforeSell = $user->coins;

        $sellResp = $this->withSession(['user_id' => $user->id])->post('/inventory/' . $boughtItem->id . '/sell');
        $sellResp->assertSessionHas('success');
        $user->refresh();
        $this->assertEquals($coinsBeforeSell + $sellPrice, $user->coins);
        $this->assertNull(Item::find($boughtItem->id));
    }
}
