<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
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
                'name'        => 'Bug',
                'description' => 'Bugs',
            ],
            [
                'name'        => 'Follow Up',
                'description' => 'Follow Up',
            ],
            [
                'name'        => 'Important',
                'description' => 'Important',
            ],
            [
                'name'        => 'Logo',
                'description' => 'Logo',
            ],
            [
                'name'        => 'Todo',
                'description' => 'Todo',
            ],
            [
                'name'        => 'Tomorrow',
                'description' => 'Tomorrow',
            ],

        ];

        foreach ($input as $tag) {
            Tag::create($tag);
        }
    }
}
