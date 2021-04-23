<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            'first_name'        => 'Super',
            'last_name'         => 'Admin',
            'email'             => 'admin@infycrm.com',
            'password'          => Hash::make('123456'),
            'phone'             => '+917878454512',
            'is_enable'         => true,
            'email_verified_at' => Carbon::now(),
        ];

        $user = User::create($input);


        /** @var \App\Models\Permission $permissions */
        $permissions = \App\Models\Permission::all();

        /** @var \App\Models\Role $adminRole */
        $adminRole = \App\Models\Role::whereName('admin')->first();
        $user->assignRole($adminRole);
        $adminRole->givePermissionTo($permissions);
        
        $user->givePermissionTo($permissions);
            
    }
}
