<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imageUrl = asset('img/infyom-logo.png');
        $faviconUrl = asset('img/infyom-favicon.png');

        Setting::create(['key' => 'logo', 'value' => $imageUrl, 'group' => Setting::GROUP_GENERAL]);
        Setting::create(['key' => 'favicon', 'value' => $faviconUrl, 'group' => Setting::GROUP_GENERAL]);
        Setting::create(['key' => 'company_name', 'value' => 'InfyOmLabs', 'group' => Setting::GROUP_GENERAL]);
        Setting::create(['key' => 'company_domain', 'value' => '127.0.0.1', 'group' => Setting::GROUP_GENERAL]);
        Setting::create([
            'key'   => 'file_type',
            'value' => '.png,.jpg,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.txt',
            'group' => Setting::GROUP_GENERAL,
        ]);
        Setting::create([
            'key'   => 'term_and_conditions',
            'value' => 'This Infycrm project is follow all term and conditions and privacy.',
            'group' => Setting::GROUP_GENERAL,
        ]);
        Setting::create(['key' => 'company', 'value' => 'InfyOmLabs', 'group' => Setting::COMPANY_INFORMATION]);
        Setting::create([
            'key'   => 'address',
            'value' => '446, Tulsi Arcade, Nr. Sudama Chowk, Mota Varachha, Surat - 394101, Gujarat, India',
            'group' => Setting::COMPANY_INFORMATION,
        ]);
        Setting::create(['key' => 'city', 'value' => 'Surat', 'group' => Setting::COMPANY_INFORMATION]);
        Setting::create(['key' => 'state', 'value' => 'Gujarat', 'group' => Setting::COMPANY_INFORMATION]);
        Setting::create(['key' => 'country_code', 'value' => 'India [IN]', 'group' => Setting::COMPANY_INFORMATION]);
        Setting::create(['key' => 'zip_code', 'value' => '394101', 'group' => Setting::COMPANY_INFORMATION]);
        Setting::create(['key' => 'phone', 'value' => '+91 70963 36561', 'group' => Setting::COMPANY_INFORMATION]);
        Setting::create(['key' => 'vat_number', 'value' => '1234567890', 'group' => Setting::COMPANY_INFORMATION]);
        Setting::create(['key' => 'current_currency', 'value' => 'inr', 'group' => Setting::COMPANY_INFORMATION]);
        Setting::create(['key' => 'website', 'value' => 'infyom.com', 'group' => Setting::COMPANY_INFORMATION]);
        Setting::create([
            'key' => 'company_information_format', 'value' => '{company_name}
                        {address}
                        {city} {state}
                        {country_code} {zip_code}
                        {vat_number_with_label}', 'group' => Setting::COMPANY_INFORMATION,
        ]);
        Setting::create([
            'key'   => 'admin_note',
            'value' => 'This is the admin note of the InfyCRM project.', 'group' => Setting::NOTE,
        ]);
        Setting::create([
            'key'   => 'client_note', 'value' => 'This is the client note of the InfyCRM project.',
            'group' => Setting::NOTE,
        ]);
    }
}
