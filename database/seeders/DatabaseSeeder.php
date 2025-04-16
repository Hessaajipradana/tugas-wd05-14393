<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Periksa;
use App\Models\Obat;
use App\Models\DetailPeriksa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat beberapa user dokter
        User::create([
            'nama' => 'Dr. Andi Pratama',
            'alamat' => 'Jl. Kesehatan No. 123, Jakarta',
            'no_hp' => '08123456789',
            'email' => 'dr.andi@example.com',
            'role' => 'dokter',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'nama' => 'Dr. Budi Santoso',
            'alamat' => 'Jl. Medis No. 45, Bandung',
            'no_hp' => '08234567890',
            'email' => 'dr.budi@example.com',
            'role' => 'dokter',
            'password' => Hash::make('password123'),
        ]);

        // Buat beberapa user pasien
        User::create([
            'nama' => 'Citra Dewi',
            'alamat' => 'Jl. Sehat No. 67, Surabaya',
            'no_hp' => '08345678901',
            'email' => 'citra@example.com',
            'role' => 'pasien',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'nama' => 'Deni Kurniawan',
            'alamat' => 'Jl. Sentosa No. 89, Medan',
            'no_hp' => '08456789012',
            'email' => 'deni@example.com',
            'role' => 'pasien',
            'password' => Hash::make('password123'),
        ]);

        // Buat beberapa data obat
        Obat::create([
            'nama_obat' => 'Paracetamol',
            'kemasan' => 'Tablet 500mg',
            'harga' => 10000,
        ]);

        Obat::create([
            'nama_obat' => 'Amoxicillin',
            'kemasan' => 'Kapsul 500mg',
            'harga' => 25000,
        ]);

        Obat::create([
            'nama_obat' => 'Ibuprofen',
            'kemasan' => 'Tablet 400mg',
            'harga' => 15000,
        ]);

        // Untuk data periksa dan detail_periksa
        $periksa = Periksa::create([
            'id_pasien' => 3, // ID Citra Dewi
            'id_dokter' => 1, // ID Dr. Andi
            'tgl_periksa' => now(),
            'catatan' => 'Pasien mengeluh demam dan sakit kepala',
            'biaya_periksa' => 150000,
        ]);

        // Tambahkan detail periksa
        DetailPeriksa::create([
            'id_periksa' => $periksa->id,
            'id_obat' => 1, // Paracetamol
        ]);
    }
}