<?php

use App\Models\CustomerGroup;
use Illuminate\Database\Seeder;

class CustomerGroupTableSeeder extends Seeder
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
                'name'        => 'High Budget',
                'description' => 'This is High Budget',
            ],
            [
                'name'        => 'Wholesaler',
                'description' => 'This is Wholesaler',
            ],
            [
                'name'        => 'VIP',
                'description' => 'This is VIP',
            ],
            [
                'name'        => 'Low Budget',
                'description' => 'This is Low Budget',
            ],
            [
                'name'        => 'Wisoky-Robel',
                'description' => 'This is Wisoky-Robel',
            ],
        ];

        foreach ($input as $data) {
            CustomerGroup::create($data);
        }
    }
}
