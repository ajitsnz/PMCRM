<?php

use App\Models\TicketPriority;
use Illuminate\Database\Seeder;

class TicketPriorityTableSeeder extends Seeder
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
                'name'   => 'Low',
                'status' => '1',
            ],
            [
                'name'   => 'Medium',
                'status' => '0',
            ],
            [
                'name'   => 'High',
                'status' => '1',
            ],
            [
                'name'   => 'Urgent',
                'status' => '0',
            ],
        ];

        foreach ($input as $data) {
            TicketPriority::create($data);
        }
    }
}
