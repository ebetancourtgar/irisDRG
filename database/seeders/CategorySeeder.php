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
            ['name' => 'Tinta'],
            ['name' => 'Consumibles'],
            ['name' => 'Refacciones'],
            ['name' => 'Multifuncional Nuevo'],
            ['name' => 'Multifuncional Usado'],
            ['name' => 'Impresora Usada'],
            ['name' => 'Impresora Nueva'],
            

        ];
        
        foreach ($categories as $category){
            Category::create($category);
        }
    }
}
