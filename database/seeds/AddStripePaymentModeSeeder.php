<?php

use App\Models\PaymentMode;
use Illuminate\Database\Seeder;

class AddStripePaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exist = PaymentMode::whereName('Stripe')->first();
        if (!$exist) {
            PaymentMode::create(['name' => 'Stripe', 'active' => true]);    
        }        
    }
}
