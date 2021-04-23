<?php

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'Empathy',
            ],
            [
                'name' => 'Communication skills',
            ],
            [
                'name' => 'Product knowledge',
            ],
            [
                'name' => 'Patience',
            ],
            [
                'name' => 'Positive attitude',
            ],
            [
                'name' => 'Positive language',
            ],
            [
                'name' => 'Personal responsibility',
            ],
            [
                'name' => 'Confidence',
            ],
            [
                'name' => 'Listening skills',
            ],
            [
                'name' => 'Adaptability',
            ],
            [
                'name' => 'Attentiveness',
            ],
            [
                'name' => 'Professionalism',
            ],
            [
                'name' => 'Acting ability',
            ],

        ];
        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
