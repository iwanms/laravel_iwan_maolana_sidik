<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalsSeeder extends Seeder
{
    public function run(): void
    {
        Hospital::create([
            'name' => 'Rumah Sakit Umum A',
            'address' => 'Jl. Contoh No. 1, Jakarta',
            'email' => 'rsumum.a@example.com',
            'no_hp' => '081234567890',
        ]);

        Hospital::create([
            'name' => 'Rumah Sakit B',
            'address' => 'Jl. Contoh No. 2, Surabaya',
            'email' => 'rsb@example.com',
            'no_hp' => '081234567891',
        ]);
    }
}
