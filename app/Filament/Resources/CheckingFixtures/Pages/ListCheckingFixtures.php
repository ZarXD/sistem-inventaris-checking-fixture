<?php

namespace App\Filament\Resources\CheckingFixtures\Pages;

use App\Filament\Resources\CheckingFixtures\CheckingFixtureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCheckingFixtures extends ListRecords
{
    protected static string $resource = CheckingFixtureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
