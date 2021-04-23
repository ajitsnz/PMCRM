<?php

use App\Models\ContractType;
use Illuminate\Database\Seeder;

class ContractTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contractTypes = [
            [
                'name' => 'Contract under Seal',
            ],
            [
                'name' => 'Express Contracts',
            ],
            [
                'name' => 'Implied Contracts',
            ],
            [
                'name' => 'Executed and Executory Contracts',
            ],
            [
                'name' => 'Bilateral and Unilateral Contracts',
            ],
            [
                'name' => 'Unconscionable Contracts',
            ],
            [
                'name' => 'Adhesion Contracts',
            ],
            [
                'name' => 'Aleatory Contracts',
            ],
            [
                'name' => 'Void and Voidable Contracts',
            ],
        ];
        foreach ($contractTypes as $contractType) {
            ContractType::create($contractType);
        }
    }
}
