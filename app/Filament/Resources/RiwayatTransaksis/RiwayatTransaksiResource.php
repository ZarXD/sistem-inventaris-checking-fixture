<?php

namespace App\Filament\Resources\RiwayatTransaksis;

use App\Filament\Resources\RiwayatTransaksis\Pages\CreateRiwayatTransaksi;
use App\Filament\Resources\RiwayatTransaksis\Pages\EditRiwayatTransaksi;
use App\Filament\Resources\RiwayatTransaksis\Pages\ListRiwayatTransaksis;
use App\Filament\Resources\RiwayatTransaksis\Schemas\RiwayatTransaksiForm;
use App\Filament\Resources\RiwayatTransaksis\Tables\RiwayatTransaksisTable;
use App\Models\RiwayatTransaksi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RiwayatTransaksiResource extends Resource
{
    protected static ?string $model = RiwayatTransaksi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::FolderOpen;

    protected static ?string $recordTitleAttribute = 'tanggal_transaksi';

    public static function form(Schema $schema): Schema
    {
        return RiwayatTransaksiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RiwayatTransaksisTable::configure($table);
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
            'index' => ListRiwayatTransaksis::route('/'),
            'create' => CreateRiwayatTransaksi::route('/create'),
            'edit' => EditRiwayatTransaksi::route('/{record}/edit'),
        ];
    }
}
