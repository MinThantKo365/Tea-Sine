<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Green Tea', 'description' => 'Classic green tea', 'price' => 2.50, 'category' => 'Tea'],
            ['name' => 'Black Tea', 'description' => 'Earl Grey style', 'price' => 2.50, 'category' => 'Tea'],
            ['name' => 'Milk Tea', 'description' => 'Creamy milk tea', 'price' => 3.50, 'category' => 'Tea'],
            ['name' => 'Iced Coffee', 'description' => 'Chilled coffee', 'price' => 3.00, 'category' => 'Coffee'],
            ['name' => 'Latte', 'description' => 'Espresso with milk', 'price' => 4.00, 'category' => 'Coffee'],
            ['name' => 'Croissant', 'description' => 'Buttery pastry', 'price' => 2.00, 'category' => 'Pastry'],
            ['name' => 'Sandwich', 'description' => 'Club sandwich', 'price' => 5.50, 'category' => 'Food'],
        ];

        foreach ($items as $item) {
            MenuItem::firstOrCreate(
                ['name' => $item['name'], 'category' => $item['category']],
                array_merge($item, ['is_available' => true])
            );
        }
    }
}
