<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['id' => '1', 'name' => 'Africa', 'description' => 'This Region Africa', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '2', 'name' => 'Americas', 'description' => 'This Region Americas', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '3', 'name' => 'Asia', 'description' => 'This Region Asia', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '4', 'name' => 'Europe', 'description' => 'This Region Europe', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '5', 'name' => 'Oceania', 'description' => 'This Region Oceania', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '6', 'name' => 'Polar', 'description' => 'This Region Polar', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
        ];
        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
