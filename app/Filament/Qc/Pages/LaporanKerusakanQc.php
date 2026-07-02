<?php

namespace App\Filament\Qc\Pages;

use App\Models\CheckingFixture;
use App\Models\LaporanKerusakan;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class LaporanKerusakanQc extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;
    protected static ?string $navigationLabel = 'Laporan Kerusakan';
    protected static ?string $title           = 'Laporan Kerusakan Checking Fixture';
    protected static ?int    $navigationSort  = 2;

    public function getView(): string
    {
        return 'filament.qc.pages.laporan-kerusakan-qc';
    }

    // Form state
    public ?array $data = [];

    // Laporan yang sudah dikirim user ini (untuk ditampilkan di bawah)
    public $riwayatLaporan;

    public function mount(): void
    {
        $this->form->fill();
        $this->loadRiwayat();
    }

    public function loadRiwayat(): void
    {
        $this->riwayatLaporan = LaporanKerusakan::with('checkingFixture')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cf_id')
                    ->label('Checking Fixture')
                    ->placeholder('Pilih atau cari CF...')
                    ->options(function () {
                        return CheckingFixture::query()
                            ->select(['id', 'part_number', 'nama_cf'])
                            ->get()
                            ->mapWithKeys(fn ($item) => [
                                $item->id => "{$item->part_number} — {$item->nama_cf}"
                            ]);
                    })
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('keterangan')
                    ->label('Keterangan Kerusakan')
                    ->placeholder('Jelaskan jenis dan lokasi kerusakan secara detail...')
                    ->rows(4)
                    ->required(),

                FileUpload::make('foto_path')
                    ->label('Foto Kerusakan')
                    ->image()
                    ->directory('laporan-kerusakan')
                    ->disk('public')
                    ->maxSize(5120) // 5MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->helperText('Format: JPG, PNG, WebP. Maks. 5MB.')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $formData = $this->form->getState();

        LaporanKerusakan::create([
            'cf_id'      => $formData['cf_id'],
            'user_id'    => auth()->id(),
            'keterangan' => $formData['keterangan'],
            'foto_path'  => $formData['foto_path'],
            'status'     => 'Menunggu',
        ]);

        // Kirim notifikasi in-app ke semua admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::make()
                ->title('Laporan Kerusakan Baru')
                ->body('Ada laporan kerusakan baru dari ' . auth()->user()->nama . '.')
                ->warning()
                ->sendToDatabase($admin);
        }

        Notification::make()
            ->title('Laporan Berhasil Dikirim')
            ->body('Laporan kerusakan Anda telah terkirim. Admin akan segera menindaklanjuti.')
            ->success()
            ->send();

        $this->form->fill();
        $this->loadRiwayat();
    }
}
