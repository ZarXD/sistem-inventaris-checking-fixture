<?php

namespace App\Filament\Resources\RiwayatTransaksis\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatTransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('checkingFixture.part_number')
                    ->label('Part Number & Nama CF')
                    ->description(fn($record): string => $record->checkingFixture->nama_cf)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.nama')
                    ->label('User')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jenis_transaksi')
                    ->badge(),
                TextColumn::make('tanggal_transaksi')
                    ->timezone('Asia/Jakarta')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('tanggal_transaksi')
                ->label('Rentang Tanggal')
                ->form([
                    DatePicker::make('dari_tanggal')
                        ->label('Dari Tanggal')
                        // ->default(now()->subMonth())
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->placeholder('Pilih tanggal awal'),
                    DatePicker::make('sampai_tanggal')
                        ->label('Sampai Tanggal')
                        // ->default(now()->addMonth())
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->placeholder('Pilih tanggal akhir'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['dari_tanggal'],
                            fn (Builder $query, $date): Builder => $query->whereDate('tanggal_transaksi', '>=', $date),
                        )
                        ->when(
                            $data['sampai_tanggal'],
                            fn (Builder $query, $date): Builder => $query->whereDate('tanggal_transaksi', '<=', $date),
                        );
                })
                ->indicateUsing(function (array $data): array {
                    // Indikator kecil di atas tabel biar user tahu lagi nyaring tanggal berapa
                    $indicators = [];
                    if ($data['dari_tanggal'] ?? null) {
                        $indicators[] = 'Dari: ' . \Carbon\Carbon::parse($data['dari_tanggal'])->format('d M Y');
                    }
                    if ($data['sampai_tanggal'] ?? null) {
                        $indicators[] = 'Sampai: ' . \Carbon\Carbon::parse($data['sampai_tanggal'])->format('d M Y');
                    }
                    return $indicators;
                })
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('cetak_pdf')
                    ->label('Cetak PDF')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->action(function (Collection $records) {
                        // Kirim data baris yang dicentang user ke view blade kustom
                        $pdf = Pdf::loadView('pdf.riwayat', [
                            'riwayat' => $records,
                            'tanggal_cetak' => now()->timezone('Asia/Jakarta')->format('d M Y, H:i')
                        ])->setPaper('a4', 'portrait');

                        // Download otomatis secara sat-set tanpa pindah halaman
                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'Laporan_Riwayat_Checking_Fixture_' . now()->format('Ymd_His') . '.pdf'
                        );
                    }),

                ]),
            ]);
    }
}
