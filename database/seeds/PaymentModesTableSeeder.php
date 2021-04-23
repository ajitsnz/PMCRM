<?php

use App\Models\PaymentMode;
use Illuminate\Database\Seeder;

class PaymentModesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            [
                'name'                => 'Bank',
                'active'              => true,
            ],
            [
                'name'                => 'Gold',
                'active'              => true,
            ],
        ];

        foreach ($input as $data) {
            PaymentMode::create($data);
        }
    }
}
