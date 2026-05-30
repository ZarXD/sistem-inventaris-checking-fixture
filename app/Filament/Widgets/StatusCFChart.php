<?php

namespace App\Filament\Widgets;

use App\Models\CheckingFixture;
use Filament\Widgets\ChartWidget;

class StatusCFChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Status Checking Fixture';
    protected static ?int $sort = 2; // Urutan tampil

    protected function getData(): array
    {
        // Ngambil jumlah data per status (contoh simpel)
        $tersedia = CheckingFixture::where('status_ketersediaan', 'Tersedia')->count();
        $digunakan = CheckingFixture::where('status_ketersediaan', 'Digunakan')->count();
        $perbaikan = CheckingFixture::where('status_ketersediaan', 'Perbaikan')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Total CF',
                    'data' => [$tersedia, $digunakan, $perbaikan],
                    'backgroundColor' => ['#10b981', '#f59e0b', '#ef4444'], // Hijau, Kuning, Merah
                ],
            ],
            'labels' => ['Tersedia', 'Digunakan', 'Perbaikan'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // Tipe chart-nya (bisa 'pie' atau 'doughnut')
    }
}