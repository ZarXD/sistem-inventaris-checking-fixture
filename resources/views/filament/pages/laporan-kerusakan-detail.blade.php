<x-filament-panels::page>
    @php $record = $this->getRecord(); @endphp

    <div class="space-y-6">

        {{-- ─── Status Banner ────────────────────────────────── --}}
        @php
            $statusConfig = match($record->status) {
                'Menunggu' => ['bg' => 'bg-amber-50 dark:bg-amber-900/20', 'border' => 'border-amber-200 dark:border-amber-700', 'text' => 'text-amber-700 dark:text-amber-300', 'badge' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200'],
                'Diproses' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20',   'border' => 'border-blue-200 dark:border-blue-700',   'text' => 'text-blue-700 dark:text-blue-300',   'badge' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200'],
                'Selesai'  => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'border' => 'border-green-200 dark:border-green-700', 'text' => 'text-green-700 dark:text-green-300', 'badge' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200'],
                default    => ['bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'text' => 'text-gray-700', 'badge' => 'bg-gray-100 text-gray-800'],
            };
        @endphp
        <div class="{{ $statusConfig['bg'] }} {{ $statusConfig['border'] }} border rounded-xl px-5 py-4 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Status Laporan</p>
                <p class="{{ $statusConfig['text'] }} font-bold text-lg">{{ $record->status }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-full text-sm font-bold {{ $statusConfig['badge'] }}">{{ $record->status }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- ─── Info CF & Pelapor ──────────────────────────── --}}
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm space-y-5">
                <h3 class="font-bold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3">Informasi Laporan</h3>

                <table class="w-full text-sm">
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <tr class="py-2">
                            <td class="py-2 pr-4 text-gray-500 dark:text-gray-400 font-medium w-36 align-top">Checking Fixture</td>
                            <td class="py-2 align-top">
                                <p class="font-bold text-gray-800 dark:text-white">{{ $record->checkingFixture?->part_number ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $record->checkingFixture?->nama_cf ?? '-' }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4 text-gray-500 dark:text-gray-400 font-medium w-36">Customer</td>
                            <td class="py-2">{{ $record->checkingFixture?->customer ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4 text-gray-500 dark:text-gray-400 font-medium w-36">Pelapor</td>
                            <td class="py-2">{{ $record->user?->nama ?? $record->user?->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4 text-gray-500 dark:text-gray-400 font-medium w-36">Tanggal Laporan</td>
                            <td class="py-2">{{ $record->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</td>
                        </tr>
                    </tbody>
                </table>

                <div>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Keterangan Kerusakan</p>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-sm text-gray-700 dark:text-gray-300 border border-gray-100 dark:border-gray-700">
                        {{ $record->keterangan }}
                    </div>
                </div>

                @if($record->catatan_admin)
                    <div>
                        <p class="text-xs font-semibold text-blue-500 uppercase tracking-wide mb-2 flex items-center gap-1">
                            <x-filament::icon icon="heroicon-m-chat-bubble-left-right" class="w-3.5 h-3.5" />
                            Catatan Admin
                        </p>
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 text-sm text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                            {{ $record->catatan_admin }}
                        </div>
                    </div>
                @endif
            </div>

            {{-- ─── Foto Kerusakan ─────────────────────────────── --}}
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm">
                <h3 class="font-bold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">Foto Kerusakan</h3>
                @if($record->foto_path)
                    <a href="{{ Storage::disk('public')->url($record->foto_path) }}" target="_blank" class="block">
                        <img
                            src="{{ Storage::disk('public')->url($record->foto_path) }}"
                            alt="Foto kerusakan"
                            class="w-full rounded-lg border border-gray-200 dark:border-gray-700 hover:opacity-90 transition-opacity cursor-zoom-in object-cover max-h-80"
                        />
                        <p class="text-xs text-gray-400 mt-2 text-center">Klik gambar untuk buka full size</p>
                    </a>
                @else
                    <div class="flex flex-col items-center justify-center h-48 bg-gray-100 dark:bg-gray-800 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                        <x-heroicon-o-photo class="w-10 h-10 text-gray-300 dark:text-gray-600 mb-2" />
                        <p class="text-sm text-gray-400">Tidak ada foto</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-filament-panels::page>
