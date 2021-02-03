<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'role' => 'admin',
                'phone' => '0111 111 111',
                'email' => 'admin@mail.com',
                'institutional_id' => 'ADM - 001',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Lecturer',
                'role' => 'lecturer',
                'phone' => '0222 222 222',
                'email' => 'lec@mail.com',
                'institutional_id' => 'LEC - 001',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now
            ], 
            [
                'name' => 'Student',
                'role' => 'student',
                'phone' => '0333 333 333',
                'email' => 'student@mail.com',
                'institutional_id' => 'STU - 001',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
