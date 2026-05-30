<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\CheckingFixture;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use BackedEnum;


class PencarianCF extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $pluralModelLabel = 'Pencarian CF';
    
    protected static ?string $navigationLabel = 'Pencarian CF';
    
    protected static string|\UnitEnum|null $navigationGroup = 'Transaksi';
    
    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlass;

    public function getHeading(): string
    {
        return '';
    }


    // Non-static di Filament v5
    public function getView(): string
    {
        return 'filament.qc.pages.pencarian-cf';
    }

    // Menyimpan data state dari form Filament
    public ?array $data = [];

    // State UI Detail
    public ?CheckingFixture $cf = null;
    public $statusBaru = '';

    public function mount(): void
    {
        $this->form->fill();
    }

    // Bikin skema dropdown pencarian pakai Select Component Filament
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('checking_fixture_id')
                    ->placeholder('Masukkan atau Pilih Part Number...')
                    ->options(function () {
                        return CheckingFixture::query()
                            ->select(['id', 'part_number', 'nama_cf'])
                            ->get()
                            ->mapWithKeys(fn ($item) => [$item->id => "{$item->part_number} - {$item->nama_cf}"]);
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->hiddenLabel(),
            ])
            ->statePath('data');
    }

    public function cariAlat(): void
    {
        $formData = $this->form->getState();
        $id = $formData['checking_fixture_id'] ?? null;

        $this->cf = CheckingFixture::with('lokasiRak')->find($id);

        if ($this->cf) {
            $this->statusBaru = $this->cf->status_ketersediaan;
        } else {
            Notification::make()
                ->title('Alat tidak ditemukan')
                ->danger()
                ->send();
        }
    }

    public function updateStatus(): void
    {
        if ($this->cf) {
            $this->cf->update(['status_ketersediaan' => $this->statusBaru]);

            \App\Models\RiwayatTransaksi::create([
                'cf_id' => $this->cf->id,
                'user_id' => auth()->id(),
                'jenis_transaksi' => $this->statusBaru,
                'tanggal_transaksi' => now(),
            ]);

            Notification::make()
                ->title('Status Berhasil Diperbarui & Dicatat')
                ->success()
                ->send();

            $this->kembali();
        }
    }

    public function kembali(): void
    {
        $this->cf = null;
        $this->form->fill();
    }
}
