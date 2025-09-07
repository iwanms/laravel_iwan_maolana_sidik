<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientsSeeder extends Seeder
{
    public function run(): void
    {
        Patient::create([
            'name' => 'John Doe',
            'address' => 'Jl. Pasien No. 1, Jakarta',
            'no_hp' => '085612345678',
            'hospital_id' => 1, // Merujuk ke Rumah Sakit Umum A
        ]);

        Patient::create([
            'name' => 'Jane Smith',
            'address' => 'Jl. Pasien No. 2, Surabaya',
            'no_hp' => '085612345679',
            'hospital_id' => 2, // Merujuk ke Rumah Sakit B
        ]);
    }
}
