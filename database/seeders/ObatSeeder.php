<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            [
                'nama_obat' => 'Paracetamol',
                'kemasan' => 'Tablet 500mg',
                'harga' => 10000,
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'kemasan' => 'Kapsul 500mg',
                'harga' => 25000,
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'kemasan' => 'Tablet 400mg',
                'harga' => 15000,
            ],
            [
                'nama_obat' => 'Omeprazole',
                'kemasan' => 'Kapsul 20mg',
                'harga' => 20000,
            ],
            [
                'nama_obat' => 'Levofloxacin',
                'kemasan' => 'Tablet 500mg',
                'harga' => 35000,
            ],
            [
                'nama_obat' => 'Cetirizine',
                'kemasan' => 'Tablet 10mg',
                'harga' => 8000,
            ],
            [
                'nama_obat' => 'Vitamin C',
                'kemasan' => 'Tablet 500mg',
                'harga' => 5000,
            ],
            [
                'nama_obat' => 'Antasida',
                'kemasan' => 'Suspensi 60ml',
                'harga' => 18000,
            ],
            [
                'nama_obat' => 'Diazepam',
                'kemasan' => 'Tablet 5mg',
                'harga' => 12000,
            ],
            [
                'nama_obat' => 'Metformin',
                'kemasan' => 'Tablet 500mg',
                'harga' => 15000,
            ],
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}