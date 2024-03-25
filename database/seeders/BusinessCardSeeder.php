<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_cards')->insert([
            [
                'name' => 'John Doe',
                'company' => 'ABC Company',
                'title' => 'CEO',
                'address' => '123 Main St, City, Country'
            ],
            [
                'name' => 'Jane Smith',
                'company' => 'XYZ Inc.',
                'title' => 'Marketing Manager',
                'address' => '456 Oak Ave, City, Country'
            ],

        ]);
    }
}
