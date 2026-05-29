<?php

namespace App\Filament\Resources\RiwayatTransaksis\Pages;

use App\Filament\Resources\RiwayatTransaksis\RiwayatTransaksiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatTransaksis extends ListRecords
{
    protected static string $resource = RiwayatTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
