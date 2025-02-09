<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('role', 'admin')->first();
        $categories = Category::all();
        foreach ($categories as $key => $category) {
            Book::create([
                'code' => 'CODE-' . ($key + 1),
                'title' => 'Dummy Book ' . ($key + 1),
                'author' => 'Author ' . ($key + 1),
                'stock' => 10,
                'category_id' => $category->id,
                'created_by' => $user->id,
            ]);
        }
    }
}
