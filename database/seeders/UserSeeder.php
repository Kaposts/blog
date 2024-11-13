<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alicejohnson@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bobbrown@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Charlie Davis',
                'email' => 'charliedavis@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now()
            ],
        ];

        DB::table('users')->insert($users);
    }
}
