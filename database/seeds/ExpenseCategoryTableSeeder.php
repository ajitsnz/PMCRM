<?php

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'        => 'Advertising',
                'description' => 'Advertising',
            ],
            [
                'name'        => 'Contractors',
                'description' => 'Contractors',
            ],
            [
                'name'        => 'Education and Training',
                'description' => 'Education and Training',
            ],
            [
                'name'        => 'Employee Benefits',
                'description' => 'Employee Benefits',
            ],
            [
                'name'        => 'Office Expenses & Postage',
                'description' => 'Office Expenses & Postage',
            ],
            [
                'name'        => 'Other Expenses',
                'description' => 'Other Expenses',
            ],
            [
                'name'        => 'Personal',
                'description' => 'Personal',
            ],
            [
                'name'        => 'Rent or Lease',
                'description' => 'Rent or Lease',
            ],
            [
                'name'        => 'Professional Services',
                'description' => 'Professional Services',
            ],
            [
                'name'        => 'Supplies',
                'description' => 'Supplies',
            ],
            [
                'name'        => 'Travel',
                'description' => 'Travel',
            ],
            [
                'name'        => 'Utilities',
                'description' => 'Utilities',
            ],
        ];
        foreach ($categories as $category) {
            ExpenseCategory::create($category);
        }
    }
}
