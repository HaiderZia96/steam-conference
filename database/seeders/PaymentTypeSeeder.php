<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentTypes = [['name' => 'Bank Payment'],
            ['name' => 'Onsite Payment']

        ];
        foreach ($paymentTypes as $paymentType) {
            PaymentType::create($paymentType);
        }

    }
}
