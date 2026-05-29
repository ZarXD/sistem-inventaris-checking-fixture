<?php

namespace App\Filament\Resources\LokasiRaks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LokasiRakForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_rak')
                    ->required(),
                TextInput::make('area_ruangan')
                    ->required(),
            ]);
    }
}
