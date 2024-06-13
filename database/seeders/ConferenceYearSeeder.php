<?php

namespace Database\Seeders;

use App\Models\ConferenceYear;
use Illuminate\Database\Seeder;

class ConferenceYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sessions = [['name' => 'Conference 2021','year'=>'2021'],
            ['name' => 'Conference 2022','year'=>'2022'],
            ['name' => 'Conference 2023','year'=>'2023']
        ];
        foreach ($sessions as $session) {
            ConferenceYear::create($session);
        }

    }
}
