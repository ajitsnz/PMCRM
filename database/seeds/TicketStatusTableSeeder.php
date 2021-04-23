<?php

use App\Models\TicketStatus;
use Illuminate\Database\Seeder;

class TicketStatusTableSeeder extends Seeder
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
                'name'       => 'Open',
                'pick_color' => '#fc544b',
                'is_default' => 1,
            ],
            [
                'name'       => 'In Progress',
                'pick_color' => '#6777ef',
                'is_default' => 1,
            ],
            [
                'name'       => 'Answered',
                'pick_color' => '#3abaf4',
                'is_default' => 1,
            ],
            [
                'name'       => 'On Hold',
                'pick_color' => '#ffa426',
                'is_default' => 1,
            ],
            [
                'name'       => 'Closed',
                'pick_color' => '#47c363',
                'is_default' => 1,
            ],
        ];

        foreach ($input as $ticketStatus) {
            TicketStatus::create($ticketStatus);
        }
    }
}
