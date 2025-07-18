<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
        for ($i = 1; $i <= 5; $i++) {
            Admin::create([
                'name' => "Admin $i",
                'email' => "admin$i@example.com",
                'password' => Hash::make('admin@123'), 
            ]);
        }
    }
}
