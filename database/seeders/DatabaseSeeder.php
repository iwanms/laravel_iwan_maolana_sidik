<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            HospitalsSeeder::class,
            PatientsSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
