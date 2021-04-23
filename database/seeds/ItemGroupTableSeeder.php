<?php

use App\Models\ItemGroup;
use Illuminate\Database\Seeder;

class ItemGroupTableSeeder extends Seeder
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
                'name'        => 'Consultant Services',
                'description' => 'Pain find that follow. I feel more than that, but that\'s dishonor, with a grief and a lot. It is extremely quite right that that.',
            ],
            [
                'name'        => 'LCD TV',
                'description' => 'Born to those who discovered it. Present suffering is nothing more than that. It is the pleasure of him who is willing, or.',
            ],
            [
                'name'        => 'MacBook Pro',
                'description' => 'The distinction, however, is easier, to the accepted indeed. Seeks to provide for them.',
            ],
            [
                'name'        => 'Marketing Services',
                'description' => 'Thus was born and will never interfere either. And to explain how he desires.',
            ],
            [
                'name'        => 'SEO Optimization',
                'description' => 'He who does not, therefore, the body itself in. Or they are rejecting it.',
            ],
            [
                'name'        => 'USB Stick',
                'description' => 'All but one reason. We regard any who are in a assumenda that he would consent. And it is because of it.',
            ],
        ];

        foreach ($input as $data) {
            ItemGroup::create($data);
        }
    }
}
