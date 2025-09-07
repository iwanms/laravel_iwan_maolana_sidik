<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Iwan Maolana Sidik',
            'email' => 'iwan@mail.com',
            'username' => 'iwan',
            'password' => Hash::make('password'),
        ]);
    }
}
