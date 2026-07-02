<?php

namespace App\Filament\Resources\LaporanKerusakans\Pages;

use App\Filament\Resources\LaporanKerusakans\LaporanKerusakanResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\EditAction;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class ViewLaporanKerusakan extends ViewRecord
{
    protected static string $resource = LaporanKerusakanResource::class;

    // Admin bisa langsung edit status + catatan dari halaman view
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Update Status & Catatan')
                ->form([
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
                ]),
        ];
    }

    // Tampilkan detail lengkap di view page
    public function getView(): string
    {
        return 'filament.pages.laporan-kerusakan-detail';
    }
}
