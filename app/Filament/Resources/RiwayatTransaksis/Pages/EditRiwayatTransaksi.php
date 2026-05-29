<?php

namespace App\Filament\Resources\RiwayatTransaksis\Pages;

use App\Filament\Resources\RiwayatTransaksis\RiwayatTransaksiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatTransaksi extends EditRecord
{
    protected static string $resource = RiwayatTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
