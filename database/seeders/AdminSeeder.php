<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'fname' => 'OTA',
            'lname' => 'Admin',
            'email' => 'admin@gmail.com',
            'country_code' => '+91',
            'phone' => '1234567890',
            'role' => 'super_admin',
            'password' => Hash::make('Admin@123'),
        ]);
    }
}
