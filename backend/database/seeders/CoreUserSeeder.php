<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class CoreUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@support.test'],
            ['name' => 'Admin', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        User::firstOrCreate(
            ['email' => 'support@support.test'],
            ['name' => 'Support', 'password' => Hash::make('support123'), 'role' => 'support']
        );
        User::firstOrCreate(
            ['email' => 'customer1@support.test'],
            ['name' => 'customer1', 'password' => Hash::make('cust123'), 'role' => 'customer']
        );
    }
}
