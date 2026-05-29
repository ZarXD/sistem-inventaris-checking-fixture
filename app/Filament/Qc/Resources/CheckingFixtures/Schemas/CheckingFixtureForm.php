<?php

namespace App\Filament\Qc\Resources\CheckingFixtures\Schemas;

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
                TextInput::make('lokasi_rak_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
