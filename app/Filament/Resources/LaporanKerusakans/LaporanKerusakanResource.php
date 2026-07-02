<?php

namespace App\Filament\Resources\LaporanKerusakans;

use App\Filament\Resources\LaporanKerusakans\Pages\ListLaporanKerusakans;
use App\Filament\Resources\LaporanKerusakans\Pages\ViewLaporanKerusakan;
use App\Models\LaporanKerusakan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Database\Eloquent\Collection;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKerusakanResource extends Resource
{
    protected static ?string $model = LaporanKerusakan::class;

    protected static ?string $pluralModelLabel  = 'Laporan Kerusakan';
    protected static ?string $navigationLabel   = 'Laporan Kerusakan';
    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';
    protected static ?int    $navigationSort    = 3;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            // Admin hanya bisa ubah status dan catatan
            Select::make('status')
                ->label('Status Tindak Lanjut')
                ->options([
                    'Menunggu' => 'Menunggu',
                    'Diproses' => 'Diproses',
                    'Selesai'  => 'Selesai',
                ])
                ->required(),

            Textarea::make('catatan_admin')
                ->label('Catatan Admin')
                ->placeholder('Tuliskan tindak lanjut atau catatan untuk pelapor...')
                ->rows(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(LaporanKerusakan::query()->with(['checkingFixture', 'user'])->latest())
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->timezone('Asia/Jakarta')
                    ->sortable(),

                TextColumn::make('checkingFixture.part_number')
                    ->label('Part Number / CF')
                    ->description(fn ($record) => $record->checkingFixture?->nama_cf)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.nama')
                    ->label('Pelapor')
                    ->sortable(),

                TextColumn::make('keterangan')
                    ->label('Keterangan Kerusakan')
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->keterangan),

                ImageColumn::make('foto_path')
                    ->label('Foto')
                    ->disk('public')
                    ->height(48)
                    ->width(64)
                    ->defaultImageUrl(null),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu' => 'warning',
                        'Diproses' => 'info',
                        'Selesai'  => 'success',
                        default    => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Diproses' => 'Diproses',
                        'Selesai'  => 'Selesai',
                    ])
                    ->placeholder('Semua Status'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('cetak_pdf')
                        ->label('Cetak PDF')
                        ->icon('heroicon-o-printer')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $pdf = Pdf::loadView('pdf.laporan_kerusakan', [
                                'laporan' => $records,
                                'tanggal_cetak' => now()->timezone('Asia/Jakarta')->format('d M Y, H:i')
                            ])->setPaper('a4', 'portrait');

                            return response()->streamDownload(
                                fn () => print($pdf->output()),
                                'Daftar_Laporan_Kerusakan_' . now()->format('Ymd_His') . '.pdf'
                            );
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLaporanKerusakans::route('/'),
            'view'  => ViewLaporanKerusakan::route('/{record}'),
        ];
    }
}
