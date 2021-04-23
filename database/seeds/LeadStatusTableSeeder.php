<?php

use App\Models\LeadStatus;
use Illuminate\Database\Seeder;

class LeadStatusTableSeeder extends Seeder
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
                'name'  => 'Attempted',
                'color' => '#ff2d42',
                'order' => 1,
            ],
            [
                'name'  => 'Not Attempted',
                'color' => '#84c529',
                'order' => 2,
            ],
            [
                'name'  => 'Contacted',
                'color' => '#0000ff',
                'order' => 3,
            ],
            [
                'name'  => 'New Opportunity',
                'color' => '#c0c0c0',
                'order' => 4,
            ],
            [
                'name'  => 'Additional Contact',
                'color' => '#03a9f4',
                'order' => 5,
            ],
            [
                'name'  => 'In Progress',
                'color' => '#9C27B0',
                'order' => 5,
            ],
        ];

        foreach ($input as $leadStatus) {
            LeadStatus::create($leadStatus);
        }
    }
}
