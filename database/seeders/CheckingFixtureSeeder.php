<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CheckingFixture;
use App\Models\LokasiRak;
use Faker\Factory as Faker;

class CheckingFixtureSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Cek tabel Lokasi Rak, kalau kosong bikinin 5 rak default
        if (LokasiRak::count() == 0) {
            $racks = [
                ['nama_rak' => 'Rak A',  'area_ruangan' => 'QC Lab'],
                ['nama_rak' => 'Rak B',  'area_ruangan' => 'QC Lab'],
                ['nama_rak' => 'Rak C',  'area_ruangan' => 'QC Lab'],
                ['nama_rak' => 'Rak D',  'area_ruangan' => 'QC Lab'],
                ['nama_rak' => 'Rak E',  'area_ruangan' => 'QC Lab'],
            ];
            foreach ($racks as $rack) {
                LokasiRak::create($rack);
            }
            $this->command->info('✓ 5 Lokasi Rak berhasil dibuat.');
        }

        // Ambil semua ID rak yang ada
        $lokasiRakIds = LokasiRak::pluck('id')->toArray();

        $customers    = ['AHM', 'YAMAHA', 'TOYOTA', 'ADM', 'HPPM', 'SUZUKI', 'HPM'];
        $awalanPart   = ['J', 'T'];
        $statusList   = ['Tersedia', 'Digunakan', 'Perbaikan', 'Kalibrasi', 'Dibawa Eksternal'];
        $cfPrefix     = ['Bracket', 'Cover', 'Plate', 'Stay', 'Holder', 'Panel', 'Guide', 'Base', 'Frame', 'Jig'];
        $cfSuffix     = ['Assy', 'Comp', 'Front', 'Rear', 'Left', 'Right', 'Main', 'Upper', 'Lower', 'Inner'];

        // 2. Generate 50 data dummy CF
        $count = 0;
        for ($i = 0; $i < 50; $i++) {
            $prefix    = $faker->randomElement($awalanPart);
            $number    = $faker->unique()->numerify('####');
            $partNumber = $prefix . $number;

            $namaCf = $faker->randomElement($cfPrefix) . ' ' . $faker->randomElement($cfSuffix);

            CheckingFixture::create([
                'part_number'         => $partNumber,
                'nama_cf'             => $namaCf,
                'customer'            => $faker->randomElement($customers),
                'lokasi_rak_id'       => $faker->randomElement($lokasiRakIds),
                'status_ketersediaan' => $faker->randomElement($statusList),
                'image'               => 'checking-fixtures/cf_dummy.png',
            ]);
            $count++;
        }

        $this->command->info("✓ {$count} Checking Fixture berhasil di-seed.");
    }
}
