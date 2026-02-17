<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sucursalLaguna = Branch::create([
            'name' => 'Laguna',
            'address' => 'Av. Tamazula 309',
            'phone' => '8717474000'
        ]);

        $sucursalSaltillo = Branch::create([
            'name' => 'Saltillo',
            'address' => 'Blvd. del Sol 456',
            'phone' => '555-0002'
        ]);

    }
}
