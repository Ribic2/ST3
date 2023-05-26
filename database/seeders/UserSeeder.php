<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'email' => 'vid.bukovec@test.com',
            'password' => Hash::make("test1234"),
            'name' => 'Vid',
            'surname' => 'Bukovec',
            'dateOfBirth' => Carbon::parse('2000-01-01'),
            'created_at' => Carbon::today()
        ]);
        DB::table('users')->insert([
            'email' => 'miha.novak@test.com',
            'password' => Hash::make("test1234"),
            'name' => 'Miha',
            'surname' => 'Novak',
            'dateOfBirth' => Carbon::parse('2000-01-01'),
            'created_at' => Carbon::today()
        ]);
    }
}
