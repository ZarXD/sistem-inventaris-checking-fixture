<?php

namespace App\Filament\Widgets;

use App\Models\CheckingFixture;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class CFTerbaruTable extends BaseWidget
{
    protected static ?string $heading = 'Checking Fixture Terbaru';
    protected static ?int $sort = 3; // Tampil paling bawah
    protected int | string | array $columnSpan = 'full'; // Biar lebarnya full 1 layar

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Cuma nampilin 5 data terakhir yang baru diinput
                CheckingFixture::query()->latest()->limit(5) 
            )
            ->columns([
                Tables\Columns\TextColumn::make('part_number')->label('Part Number'),
                Tables\Columns\TextColumn::make('nama_cf')->label('Nama CF'),
                Tables\Columns\TextColumn::make('lokasiRak.nama_rak')->label('Lokasi Rak'),
                Tables\Columns\TextColumn::make('status_ketersediaan')
                    ->badge() // Biar bentuknya kotak / badge
                    ->label('Status'),
            ])
            ->paginated(false); // Matiin pagination karena cuma nampilin 5 data
    }
}