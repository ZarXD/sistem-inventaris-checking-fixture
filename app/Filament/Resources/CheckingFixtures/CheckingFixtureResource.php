<?php

namespace App\Filament\Resources\CheckingFixtures;

use App\Filament\Resources\CheckingFixtures\Pages\CreateCheckingFixture;
use App\Filament\Resources\CheckingFixtures\Pages\EditCheckingFixture;
use App\Filament\Resources\CheckingFixtures\Pages\ListCheckingFixtures;
use App\Filament\Resources\CheckingFixtures\Schemas\CheckingFixtureForm;
use App\Filament\Resources\CheckingFixtures\Tables\CheckingFixturesTable;
use App\Models\CheckingFixture;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CheckingFixtureResource extends Resource
{
    protected static ?string $model = CheckingFixture::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'part_number';

    public static function form(Schema $schema): Schema
    {
        return CheckingFixtureForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CheckingFixturesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCheckingFixtures::route('/'),
            'create' => CreateCheckingFixture::route('/create'),
            'edit' => EditCheckingFixture::route('/{record}/edit'),
        ];
    }
}
