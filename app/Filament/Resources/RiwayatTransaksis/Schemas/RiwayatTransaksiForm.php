<?php

namespace App\Filament\Resources\RiwayatTransaksis\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RiwayatTransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cf_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Select::make('jenis_transaksi')
                    ->options([
            'Penggunaan' => 'Penggunaan',
            'Perbaikan' => 'Perbaikan',
            'Kalibrasi' => 'Kalibrasi',
            'Dibawa Eksternal' => 'Dibawa eksternal',
            'Pengembalian' => 'Pengembalian',
        ])
                    ->default('Penggunaan')
                    ->required(),
                DateTimePicker::make('tanggal_transaksi')
                    ->required(),
            ]);
    }
}
