<?php

namespace App\Filament\Qc\Resources\CheckingFixtures\Pages;

use App\Filament\Qc\Resources\CheckingFixtures\CheckingFixtureResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCheckingFixture extends ViewRecord
{
    protected static string $resource = CheckingFixtureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
