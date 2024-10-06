<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'birth_date' => '2000-01-01',
            'last_name' => 'Admin',
            'first_name' => 'Admin',
            'email' => 'admin@fin.zvany.com',
            'gender' => 'M',
            'phone' => '0000000000',
            'password' => bcrypt('password'),
        ]);
    }
}
