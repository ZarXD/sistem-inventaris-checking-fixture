<?php

namespace App\Filament\Qc\Resources\CheckingFixtures\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CheckingFixtureInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('part_number'),
                TextEntry::make('customer'),
                TextEntry::make('nama_cf'),
                TextEntry::make('status_ketersediaan')
                    ->badge(),
                TextEntry::make('lokasi_rak_id')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
