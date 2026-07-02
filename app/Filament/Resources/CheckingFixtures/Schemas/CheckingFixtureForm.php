<?php

namespace App\Filament\Resources\CheckingFixtures\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CheckingFixtureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('part_number')
                    ->required(),
                TextInput::make('customer')
                    ->required(),
                TextInput::make('nama_cf')
                    ->required(),
                Select::make('status_ketersediaan')
                    ->options([
            'Tersedia' => 'Tersedia',
            'Digunakan' => 'Digunakan',
            'Perbaikan' => 'Perbaikan',
            'Kalibrasi' => 'Kalibrasi',
            'Dibawa Eksternal' => 'Dibawa eksternal',
        ])
                    ->default('Tersedia')
                    ->required(),
                Select::make('lokasi_rak_id')
                    ->label('Lokasi Rak')
                    ->relationship('lokasiRak', 'nama_rak')
                    ->searchable()
                    ->preload()
                    ->required(),
                \Filament\Forms\Components\FileUpload::make('image')
                    ->label('Foto CF')
                    ->image()
                    ->disk('public')
                    ->directory('checking-fixtures')
                    ->maxSize(5120)
                    ->columnSpanFull(),
            ]);
    }
}
