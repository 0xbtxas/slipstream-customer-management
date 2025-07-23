<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerCategory;

class CustomerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        CustomerCategory::insert([
            ['name' => 'Gold', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Silver', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bronze', 'created_at' => $now, 'updated_at' => $now],
        ]);    
    }
}
