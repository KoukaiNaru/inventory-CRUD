<?php

namespace Database\Seeders;

use App\Models\Catalog;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Базовые ресурсы
            ['name' => 'Дерево', 'type' => 'resource', 'power' => 0, 'price' => 5],
            ['name' => 'Камень', 'type' => 'resource', 'power' => 0, 'price' => 8],
            ['name' => 'Железо', 'type' => 'resource', 'power' => 0, 'price' => 15],

            // Инструменты для добычи
            ['name' => 'Каменная кирка', 'type' => 'tool', 'power' => 10, 'price' => 40],
            ['name' => 'Железная кирка', 'type' => 'tool', 'power' => 25, 'price' => 100],

            // Оружие
            ['name' => 'Дубина', 'type' => 'weapon', 'power' => 15, 'price' => 30],
            ['name' => 'Каменный нож', 'type' => 'weapon', 'power' => 25, 'price' => 60],
            ['name' => 'Стальной меч', 'type' => 'weapon', 'power' => 55, 'price' => 160],
            ['name' => 'Мифриловый клинок', 'type' => 'weapon', 'power' => 90, 'price' => 400],
        ];

        foreach ($items as $item) {
            Catalog::updateOrCreate(
                ['name' => $item['name']],
                [
                    'type' => $item['type'],
                    'power' => $item['power'],
                    'price' => $item['price'],
                ]
            );
        }
    }
}
