<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'id' => 1,
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('secret'),
            'role' => 'super_admin',
        ]);

        User::factory()->create([
            'id' => 2,
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('secret'),
            'role' => 'admin',
        ]);
    }
}
