<?php

namespace App\Filament\Resources\LokasiRaks\Pages;

use App\Filament\Resources\LokasiRaks\LokasiRakResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLokasiRak extends EditRecord
{
    protected static string $resource = LokasiRakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
