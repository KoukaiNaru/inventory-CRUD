<?php

namespace Database\Seeders;

use App\Models\Catalog;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wood = Catalog::where('name', 'Дерево')->first();
        $stone = Catalog::where('name', 'Камень')->first();
        $iron = Catalog::where('name', 'Железо')->first();

        $club = Catalog::where('name', 'Дубина')->first();
        $knife = Catalog::where('name', 'Каменный нож')->first();
        $stonePickaxe = Catalog::where('name', 'Каменная кирка')->first();
        $ironPickaxe = Catalog::where('name', 'Железная кирка')->first();

        if (!$wood || !$stone || !$iron) {
            return;
        }

        $recipes = [
            // Дубина = 3 Дерева
            ['item_id' => $club?->id, 'ingredient_id' => $wood->id, 'quantity' => 3],
            // Каменный нож = 1 Дерево + 3 Камня
            ['item_id' => $knife?->id, 'ingredient_id' => $wood->id, 'quantity' => 1],
            ['item_id' => $knife?->id, 'ingredient_id' => $stone->id, 'quantity' => 3],
            // Каменная кирка = 2 Дерева + 3 Камня
            ['item_id' => $stonePickaxe?->id, 'ingredient_id' => $wood->id, 'quantity' => 2],
            ['item_id' => $stonePickaxe?->id, 'ingredient_id' => $stone->id, 'quantity' => 3],
            // Железная кирка = 2 Дерева + 3 Железа
            ['item_id' => $ironPickaxe?->id, 'ingredient_id' => $wood->id, 'quantity' => 2],
            ['item_id' => $ironPickaxe?->id, 'ingredient_id' => $iron->id, 'quantity' => 3],
        ];

        foreach ($recipes as $recipe) {
            if ($recipe['item_id'] && $recipe['ingredient_id']) {
                Recipe::firstOrCreate(
                    ['item_id' => $recipe['item_id'], 'ingredient_id' => $recipe['ingredient_id']],
                    ['quantity' => $recipe['quantity']]
                );
            }
        }
    }
}
