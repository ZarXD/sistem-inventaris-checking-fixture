<?php

namespace App\Filament\Pages;

use App\Models\CheckingFixture;
use App\Models\LokasiRak;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class LaporanRekapCF extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationLabel  = 'Rekap Checking Fixture';
    protected static ?string $title            = 'Laporan Rekap Checking Fixture';
    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';
    protected static ?int   $navigationSort    = 2;
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    public function getView(): string
    {
        return 'filament.pages.laporan-rekap-c-f';
    }

    // ── State filter form PDF ──────────────────────────────
    public ?string $filterStatus   = null;
    public ?string $filterLokasi   = null;
    public ?string $filterCustomer = null;

    // ── Stats ──────────────────────────────────────────────
    public function getStats(): array
    {
        return [
            ['label' => 'Total CF',         'value' => CheckingFixture::count(),                                          'color' => '#6b7280', 'icon' => 'heroicon-o-circle-stack'],
            ['label' => 'Tersedia',          'value' => CheckingFixture::where('status_ketersediaan', 'Tersedia')->count(),         'color' => '#10b981', 'icon' => 'heroicon-o-check-circle'],
            ['label' => 'Digunakan',         'value' => CheckingFixture::where('status_ketersediaan', 'Digunakan')->count(),        'color' => '#f59e0b', 'icon' => 'heroicon-o-clock'],
            ['label' => 'Perbaikan',         'value' => CheckingFixture::where('status_ketersediaan', 'Perbaikan')->count(),        'color' => '#ef4444', 'icon' => 'heroicon-o-wrench-screwdriver'],
            ['label' => 'Kalibrasi',         'value' => CheckingFixture::where('status_ketersediaan', 'Kalibrasi')->count(),        'color' => '#8b5cf6', 'icon' => 'heroicon-o-adjustments-horizontal'],
            ['label' => 'Dibawa Eksternal',  'value' => CheckingFixture::where('status_ketersediaan', 'Dibawa Eksternal')->count(), 'color' => '#64748b', 'icon' => 'heroicon-o-briefcase'],
        ];
    }

    // ── Filament Table ─────────────────────────────────────
    public function table(Table $table): Table
    {
        return $table
            ->query(CheckingFixture::query()->with('lokasiRak'))
            ->columns([
                Tables\Columns\TextColumn::make('part_number')
                    ->label('Part Number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_cf')
                    ->label('Nama CF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lokasiRak.nama_rak')
                    ->label('Lokasi Rak')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_ketersediaan')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Tersedia'        => 'success',
                        'Digunakan'       => 'warning',
                        'Perbaikan'       => 'danger',
                        'Kalibrasi'       => 'info',
                        'Dibawa Eksternal'=> 'gray',
                        default           => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status_ketersediaan')
                    ->label('Status Ketersediaan')
                    ->options([
                        'Tersedia'         => 'Tersedia',
                        'Digunakan'        => 'Digunakan',
                        'Perbaikan'        => 'Perbaikan',
                        'Kalibrasi'        => 'Kalibrasi',
                        'Dibawa Eksternal' => 'Dibawa Eksternal',
                    ])
                    ->placeholder('Semua Status'),
                SelectFilter::make('lokasi_rak_id')
                    ->label('Lokasi Rak')
                    ->relationship('lokasiRak', 'nama_rak')
                    ->placeholder('Semua Lokasi'),
                SelectFilter::make('customer')
                    ->label('Customer')
                    ->options(fn () => CheckingFixture::query()
                        ->distinct()
                        ->pluck('customer', 'customer')
                        ->filter()
                        ->toArray()
                    )
                    ->placeholder('Semua Customer'),
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent)
            ->toolbarActions([
                Action::make('cetak_pdf')
                    ->label('Cetak PDF')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->action(function () {
                        // Ambil state filter dari tabel Filament
                        $tableFilters = $this->tableFilters ?? [];

                        $query = CheckingFixture::query()->with('lokasiRak');

                        // Terapkan filter yang aktif
                        if (!empty($tableFilters['status_ketersediaan']['value'])) {
                            $query->where('status_ketersediaan', $tableFilters['status_ketersediaan']['value']);
                        }
                        if (!empty($tableFilters['lokasi_rak_id']['value'])) {
                            $query->where('lokasi_rak_id', $tableFilters['lokasi_rak_id']['value']);
                        }
                        if (!empty($tableFilters['customer']['value'])) {
                            $query->where('customer', $tableFilters['customer']['value']);
                        }

                        $data = $query->get();

                        // Ringkasan status dari data hasil filter
                        $ringkasan = [
                            'Tersedia'         => $data->where('status_ketersediaan', 'Tersedia')->count(),
                            'Digunakan'        => $data->where('status_ketersediaan', 'Digunakan')->count(),
                            'Perbaikan'        => $data->where('status_ketersediaan', 'Perbaikan')->count(),
                            'Kalibrasi'        => $data->where('status_ketersediaan', 'Kalibrasi')->count(),
                            'Dibawa Eksternal' => $data->where('status_ketersediaan', 'Dibawa Eksternal')->count(),
                        ];

                        // Bangun label filter aktif untuk keterangan di PDF
                        $filterLabel = [];
                        if (!empty($tableFilters['status_ketersediaan']['value'])) {
                            $filterLabel[] = 'Status: ' . $tableFilters['status_ketersediaan']['value'];
                        }
                        if (!empty($tableFilters['lokasi_rak_id']['value'])) {
                            $rak = LokasiRak::find($tableFilters['lokasi_rak_id']['value']);
                            $filterLabel[] = 'Lokasi: ' . ($rak?->nama_rak ?? '-');
                        }
                        if (!empty($tableFilters['customer']['value'])) {
                            $filterLabel[] = 'Customer: ' . $tableFilters['customer']['value'];
                        }

                        $pdf = Pdf::loadView('pdf.rekap_cf', [
                            'data'          => $data,
                            'ringkasan'     => $ringkasan,
                            'filter_label'  => empty($filterLabel) ? 'Semua Data' : implode(', ', $filterLabel),
                            'tanggal_cetak' => now()->timezone('Asia/Jakarta')->format('d M Y, H:i'),
                        ])->setPaper('a4', 'portrait');

                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'Laporan_Rekap_CF_' . now()->format('Ymd_His') . '.pdf'
                        );
                    }),
            ]);
    }
}
