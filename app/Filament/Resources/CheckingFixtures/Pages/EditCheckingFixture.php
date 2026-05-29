<?php

namespace App\Filament\Resources\CheckingFixtures\Pages;

use App\Filament\Resources\CheckingFixtures\CheckingFixtureResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCheckingFixture extends EditRecord
{
    protected static string $resource = CheckingFixtureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
