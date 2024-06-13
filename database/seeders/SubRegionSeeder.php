<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\SubRegion;
use Illuminate\Database\Seeder;

class SubRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subRegions = [
            ['id' => '1','name' => 'Northern Africa','region_id' => '1','description' => 'This Sub Region Northern Africa', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '2','name' => 'Middle Africa','region_id' => '1','description' => 'This Sub Region Middle Africa', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '3','name' => 'Western Africa','region_id' => '1','description' => 'This Sub Region Western Africa', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '4','name' => 'Eastern Africa','region_id' => '1','description' => 'This Sub Region Eastern Africa', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '5','name' => 'Southern Africa','region_id' => '1','description' => 'This Sub Region Southern Africa', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '6','name' => 'Northern America','region_id' => '2','description' => 'This Sub Region Northern America', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '7','name' => 'Caribbean','region_id' => '2','description' => 'This Sub Region Caribbean', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '8','name' => 'South America','region_id' => '2','description' => 'This Sub Region South America', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '9','name' => 'Central America','region_id' => '2','description' => 'This Sub Region Central America', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '10','name' => 'Central Asia','region_id' => '3','description' => 'This Sub Region Central Asia', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '11','name' => 'Western Asia','region_id' => '3','description' => 'This Sub Region Western Asia', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '12','name' => 'Eastern Asia','region_id' => '3','description' => 'This Sub Region Eastern Asia', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '13','name' => 'South-Eastern Asia','region_id' => '3','description' => 'This Sub Region South-Eastern Asia', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '14','name' => 'Southern Asia','region_id' => '3','description' => 'This Sub Region Southern Asia', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '15','name' => 'Eastern Europe','region_id' => '4','description' => 'This Sub Region Eastern Europe', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '16','name' => 'Southern Europe','region_id' => '4','description' => 'This Sub Region Southern Europe', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '17','name' => 'Western Europe','region_id' => '4','description' => 'This Sub Region Western Europe', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '18','name' => 'Northern Europe','region_id' => '4','description' => 'This Sub Region Northern Europe', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '19','name' => 'Australia and New Zealand','region_id' => '5','description' => 'This Sub Region Australia and New Zealand', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '20','name' => 'Melanesia','region_id' => '5','description' => 'This Sub Region Melanesia', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '21','name' => 'Micronesia','region_id' => '5','description' => 'This Sub Region Micronesia', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04'],
            ['id' => '22','name' => 'Polynesia','region_id' => '5','description' => 'This Sub Region Polynesia', 'status' => 1, 'created_by' => 1, 'updated_by' => null, 'deleted_by' => null, 'created_at' => '2023-09-07 12:11:03', 'updated_at' => '2023-09-07 12:11:04']
        ];

        foreach ($subRegions as $sub_regions) {
            SubRegion::create($sub_regions);
        }
    }
}
