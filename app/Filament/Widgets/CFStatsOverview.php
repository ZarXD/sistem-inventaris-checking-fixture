<?php

namespace App\Filament\Widgets;

use App\Models\CheckingFixture;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CFStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Checking Fixture', CheckingFixture::count()),
            
            Stat::make('Tersedia', CheckingFixture::where('status_ketersediaan', 'Tersedia')->count())
                ->description('Siap digunakan') // Teks tambahan di bawah
                ->descriptionIcon('heroicon-m-check-circle') // Icon pindah ke sini
                ->color('success'), // Warna otomatis teraplikasi ke description & icon
                
            Stat::make('Digunakan', CheckingFixture::where('status_ketersediaan', 'Digunakan')->count())
                ->description('Sedang dipakai')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
                
            Stat::make('Perbaikan', CheckingFixture::where('status_ketersediaan', 'Perbaikan')->count())
                ->description('Dalam perbaikan')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('danger'),
                
            Stat::make('Kalibrasi', CheckingFixture::where('status_ketersediaan', 'Kalibrasi')->count())
                ->description('Proses kalibrasi')
                ->descriptionIcon('heroicon-m-adjustments-horizontal')
                ->color('info'),
                
            Stat::make('Dibawa Eksternal', CheckingFixture::where('status_ketersediaan', 'Dibawa Eksternal')->count())
                ->description('Di luar pabrik')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('gray'),
        ];
    }
}