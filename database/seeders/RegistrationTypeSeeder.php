<?php

namespace Database\Seeders;

use App\Models\RegistrationType;
use Illuminate\Database\Seeder;

class RegistrationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $registrationTypes = [['name' => 'Student', 'fee' => '3000','international_fee' =>'50'],
            ['name' => 'Faculty', 'fee' => '4000','international_fee'=>'100'],
        ];
        foreach ($registrationTypes as $registrationType) {
            RegistrationType::create($registrationType);
        }

    }
}
