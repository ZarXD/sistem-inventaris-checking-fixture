<?php

namespace App\Filament\Widgets;

use App\Models\LokasiRak;
use Filament\Widgets\ChartWidget;

class LokasiCFChart extends ChartWidget
{
    protected ?string $heading = 'Checking Fixture per Lokasi Rak';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Mengambil semua data rak beserta jumlah CF (Checking Fixture) di masing-masing rak
        $rakData = LokasiRak::withCount('checkingFixtures')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total CF',
                    // Narik angka total CF-nya
                    'data' => $rakData->pluck('checking_fixtures_count')->toArray(), 
                    // Warna batang grafiknya (abu-abu kayak di wireframe)
                    'backgroundColor' => '#9ca3af', 
                ],
            ],
            // Narik nama-nama raknya buat dijadiin label di bawah grafik
            'labels' => $rakData->pluck('nama_rak')->toArray(), 
        ];
    }

    protected function getType(): string
    {
        // Nah, ini yang nentuin jenisnya jadi grafik batang!
        return 'bar'; 
    }
}