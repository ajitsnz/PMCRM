<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
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
                'name'        => 'en',
                'description' => 'English',
            ],
            [
                'name'        => 'es',
                'description' => 'Spanish',
            ],
            [
                'name'        => 'fr',
                'description' => 'French',
            ],
            [
                'name'        => 'de',
                'description' => 'German',
            ],
            [
                'name'        => 'ru',
                'description' => 'Russian',
            ],
            [
                'name'        => 'pt',
                'description' => 'Portuguese',
            ],
            [
                'name'        => 'ar',
                'description' => 'Arabic',
            ],
            [
                'name'        => 'zh',
                'description' => 'Chinese',
            ],
            [
                'name'        => 'tr',
                'description' => 'Turkish',
            ]
        ];

        foreach ($input as $data) {
            Language::create($data);
        }
    }
}
