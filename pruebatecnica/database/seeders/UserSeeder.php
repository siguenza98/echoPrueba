<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'admin',
            'last_name' => '',
            'dui' => '05726081-3',
            'verification_code' => Str::random(10),
            'last_login' => now(),
            'email' => 'fernando.siguenza.98@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ])->assignRole('admin');

        User::create([
            'first_name' => 'bodeguero',
            'last_name' => '',
            'dui' => '05726081-4',
            'verification_code' => Str::random(10),
            'last_login' => now(),
            'email' => 'bodeguero@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ])->assignRole('inventory_manager');

        User::create([
            'first_name' => 'contador',
            'last_name' => '',
            'dui' => '05726081-5',
            'verification_code' => Str::random(10),
            'last_login' => now(),
            'email' => 'conta@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ])->assignRole('accountant');

        User::create([
            'first_name' => 'cliente',
            'last_name' => '',
            'dui' => '05726081-6',
            'verification_code' => Str::random(10),
            'last_login' => now(),
            'email' => 'cliente@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ])->assignRole('client');
    }
}
