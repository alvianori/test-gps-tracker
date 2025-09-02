<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['name' => 'Gratis Cuci Motor', 'description' => 'Termasuk layanan cuci motor gratis'],
            ['name' => 'Garansi 7 Hari', 'description' => 'Garansi servis selama 7 hari'],
            ['name' => 'Penggantian Oli', 'description' => 'Oli diganti gratis pada paket tertentu'],
            ['name' => 'Antar Jemput', 'description' => 'Layanan antar jemput kendaraan dari rumah ke bengkel'],
            ['name' => 'Diskon Sparepart', 'description' => 'Potongan harga khusus untuk pembelian sparepart'],
            ['name' => 'Pemeriksaan Rem Gratis', 'description' => 'Cek kondisi rem tanpa biaya tambahan'],
            ['name' => 'Cek Aki & Kelistrikan', 'description' => 'Pemeriksaan kelistrikan lengkap termasuk aki'],
            ['name' => 'Pembersihan Filter Udara', 'description' => 'Membersihkan filter udara secara gratis'],
            ['name' => 'Pengecekan Ban & Tekanan', 'description' => 'Cek kondisi ban dan tekanan angin secara gratis'],
            ['name' => 'Layanan Darurat 24 Jam', 'description' => 'Bantuan darurat kapan saja jika kendaraan mogok'],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
