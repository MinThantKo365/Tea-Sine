<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            MenuItemSeeder::class,
        ]);

        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        $cashierRole = \App\Models\Role::where('name', 'cashier')->first();
        $cookRole = \App\Models\Role::where('name', 'cook')->first();
        $staffRole = \App\Models\Role::where('name', 'staff')->first();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole?->id,
        ]);
        User::factory()->create([
            'name' => 'Cashier',
            'email' => 'cashier@example.com',
            'password' => Hash::make('password'),
            'role_id' => $cashierRole?->id,
        ]);
        User::factory()->create([
            'name' => 'Cook',
            'email' => 'cook@example.com',
            'password' => Hash::make('password'),
            'role_id' => $cookRole?->id,
        ]);
        $staffUser = User::factory()->create([
            'name' => 'Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role_id' => $staffRole?->id,
        ]);
        \App\Models\Staff::create([
            'user_id' => $staffUser->id,
            'employee_code' => 'EMP001',
            'basic_salary' => 2500,
            'overtime_rate_per_hour' => 15,
            'joined_at' => now(),
        ]);
    }
}
