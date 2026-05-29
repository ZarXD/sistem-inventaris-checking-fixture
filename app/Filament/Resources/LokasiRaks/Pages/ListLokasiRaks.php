<?php

namespace App\Filament\Resources\LokasiRaks\Pages;

use App\Filament\Resources\LokasiRaks\LokasiRakResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLokasiRaks extends ListRecords
{
    protected static string $resource = LokasiRakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
