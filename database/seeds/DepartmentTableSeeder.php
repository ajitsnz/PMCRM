<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
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
                'name'                     => 'Marketing Department',
            ],
            [
                'name'                     => 'Operations Department',
            ],
            [
                'name'                     => 'Finance Department',
            ],
            [
                'name'                     => 'Sales Department',
            ],
            [
                'name'                     => 'Human Resource Department',
            ],
            [
                'name'                     => 'Purchase Department',
            ],
        ];

        foreach ($input as $department) {
            Department::create($department);
        }
    }
}
