<?php

namespace App\Filament\Resources\LokasiRaks;

use App\Filament\Resources\LokasiRaks\Pages\CreateLokasiRak;
use App\Filament\Resources\LokasiRaks\Pages\EditLokasiRak;
use App\Filament\Resources\LokasiRaks\Pages\ListLokasiRaks;
use App\Filament\Resources\LokasiRaks\Schemas\LokasiRakForm;
use App\Filament\Resources\LokasiRaks\Tables\LokasiRaksTable;
use App\Models\LokasiRak;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LokasiRakResource extends Resource
{
    protected static ?string $pluralModelLabel = 'Lokasi Rak';
    
    protected static ?string $navigationLabel = 'Lokasi Rak';
    
    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';
    
    protected static ?int $navigationSort = 2;

    protected static ?string $model = LokasiRak::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $recordTitleAttribute = 'nama_rak';

    public static function form(Schema $schema): Schema
    {
        return LokasiRakForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LokasiRaksTable::configure($table);
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
            'index' => ListLokasiRaks::route('/'),
            'create' => CreateLokasiRak::route('/create'),
            'edit' => EditLokasiRak::route('/{record}/edit'),
        ];
    }
}
