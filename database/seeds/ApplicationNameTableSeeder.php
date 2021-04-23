<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class ApplicationNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $applicationName = Setting::where(['key' => 'company_name', 'group' => Setting::GROUP_GENERAL])->first();
        $applicationName->update(['value' => 'InfyCRM']);
    }
}
