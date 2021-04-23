<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
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
                'name'         => 'admin',
                'display_name' => 'Admin',
                'is_default'   => true,
            ],
            [
                'name'         => 'staff_member',
                'display_name' => 'Staff Member',
                'is_default'   => true,
            ],
            [
                'name'         => 'client',
                'display_name' => 'Client',
                'is_default'   => true,
            ],
        ];

        foreach ($input as $value) {
            Role::create($value);
        }
    }
}
