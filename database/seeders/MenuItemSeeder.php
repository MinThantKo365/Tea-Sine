<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Phone Mhan Tea', 'description' => 'Classic tea', 'price' => 2000, 'category' => 'Tea'],
            ['name' => 'Cho Saint Tea', 'description' => 'Sweet milk tea', 'price' => 2000, 'category' => 'Tea'],
            ['name' => 'Kya Saint Tea', 'description' => 'Strong milk tea', 'price' => 2000, 'category' => 'Tea'],
            ['name' => 'Cho-kya Tea', 'description' => 'Sweet and strong tea', 'price' => 2000, 'category' => 'Tea'],
            ['name' => 'Se Lone Tea', 'description' => 'Tea with Malai (milky/buttery)', 'price' => 2000, 'category' => 'Tea'],
            ['name' => 'Three-color Tea', 'description' => 'Condensed, evaporated, and brewed tea', 'price' => 3500, 'category' => 'Tea'],
            ['name' => 'Lahpet Thoke', 'description' => 'Tea leaf salad', 'price' => 2500, 'category' => 'Food'],
        ];

        foreach ($items as $item) {
            MenuItem::firstOrCreate(
                ['name' => $item['name'], 'category' => $item['category']],
                array_merge($item, ['is_available' => true])
            );
        }
    }
}
