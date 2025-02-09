<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('role', 'admin')->first('id');

        $category = ['Fiction', 'Non-Fiction'];
        foreach ($category as $key => $value) {
            Category::create([
                'name' => $value,
                'created_by' => $user->id,
            ]);
        }
        
    }
}
