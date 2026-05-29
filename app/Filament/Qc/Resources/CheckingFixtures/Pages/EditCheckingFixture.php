<?php

namespace App\Filament\Qc\Resources\CheckingFixtures\Pages;

use App\Filament\Qc\Resources\CheckingFixtures\CheckingFixtureResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCheckingFixture extends EditRecord
{
    protected static string $resource = CheckingFixtureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
