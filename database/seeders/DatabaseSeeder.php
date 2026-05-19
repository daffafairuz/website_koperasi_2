<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin
        User::create([
            'name' => 'Admin Koperasi',
            'email' => 'admin@koperasi.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'member_number' => 'ADM-001',
            'phone' => '081234567890',
            'address' => 'Kantor Koperasi Pusat, Jakarta',
        ]);

        // Create a test Member (Anggota)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'anggota@koperasi.com',
            'password' => bcrypt('anggota123'),
            'role' => 'member',
            'member_number' => 'KOP-2026001',
            'phone' => '089876543210',
            'address' => 'Jl. Merdeka No. 10, Bandung',
            'simpanan_pokok' => 500000,
            'simpanan_wajib' => 1200000,
            'simpanan_sukarela' => 850000,
            'hutang' => 2000000,
            'pokok_pinjaman' => 5000000,
            'monthly_payment' => 500000,
            'jatuh_tempo_pinjaman' => date('Y-m-d', strtotime('+15 days')),
        ]);
    }
}
