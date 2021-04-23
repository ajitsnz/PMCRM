<?php

use App\Models\TaxRate;
use Illuminate\Database\Seeder;

class TaxRateTableSeeder extends Seeder
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
                'name'     => 'Madera',
                'tax_rate' => '1',
            ],
            [
                'name'     => 'Fernado',
                'tax_rate' => '2',
            ],
            [
                'name'     => 'Agow',
                'tax_rate' => '5',
            ],
            [
                'name'     => 'Moon',
                'tax_rate' => '10',
            ],
            [
                'name'     => 'Agxm',
                'tax_rate' => '15',
            ],
            [
                'name'     => 'County',
                'tax_rate' => '20',
            ],
        ];

        foreach ($input as $data) {
            TaxRate::create($data);
        }
    }
}
