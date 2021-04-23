<?php

use App\Models\LeadSource;
use Illuminate\Database\Seeder;

class LeadSourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leadSources = [
            [
                'name' => 'Google AdWords',
            ],
            [
                'name' => 'Other Search Engines',
            ],
            [
                'name' => 'Google (organic)',
            ],
            [
                'name' => 'Social Media (Facebook, Twitter etc)',
            ],
            [
                'name' => 'Cold Calling/Telemarketing',
            ],
            [
                'name' => 'Advertising',
            ],
            [
                'name' => 'Custom Referral',
            ],
            [
                'name' => 'Expo/Seminar',
            ],
        ];
        foreach ($leadSources as $leadSource) {
            LeadSource::create($leadSource);
        }
    }
}
