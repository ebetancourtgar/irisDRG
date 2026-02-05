<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Tóner'],
            ['name' => 'Cartuchos de tinta'],
            ['name' => 'Refacciones'],
            ['name' => 'Equipo Nuevo'],
            ['name' => 'Equipo Usado'],
        ];
        
        foreach ($categories as $category){
            Category::create($category);
        }
    }
}
