<x-filament-panels::page>
    <div>

        {{-- ─── Form Laporan Baru ────────────────────────────────── --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-red-500" />
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Form Laporan Kerusakan</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500">Isi formulir berikut untuk melaporkan kerusakan CF ke Admin</p>
                </div>
            </div>

            <div class="p-6">
                <form wire:submit.prevent="submit" class="space-y-5">
                    {{ $this->form }}

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full py-2.5 bg-[#ff7900] hover:bg-[#e06c00] text-white font-semibold rounded-lg shadow transition-colors flex items-center justify-center gap-2 text-sm"
                        >
                            <x-heroicon-o-paper-airplane class="w-4 h-4" />
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ─── Riwayat Laporan Saya ─────────────────────────────── --}}
        {{-- Pakai inline style margin-top biar pasti ada jarak --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden" style="margin-top: 32px;">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <x-heroicon-o-clipboard-document-list class="w-5 h-5 text-blue-500" />
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Riwayat Laporan Saya</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500">Laporan yang telah Anda kirim beserta status tindak lanjut</p>
                </div>
            </div>

            <div class="p-6">
                @if($riwayatLaporan && $riwayatLaporan->count() > 0)
                    <div class="space-y-4">
                        @foreach($riwayatLaporan as $laporan)
                            @php
                                $statusColor = match($laporan->status) {
                                    'Menunggu' => ['bg' => 'bg-amber-50 dark:bg-amber-900/20', 'text' => 'text-amber-600 dark:text-amber-400', 'border' => 'border-amber-200 dark:border-amber-700', 'badge' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300'],
                                    'Diproses' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20',  'text' => 'text-blue-600 dark:text-blue-400',   'border' => 'border-blue-200 dark:border-blue-700',   'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'],
                                    'Selesai'  => ['bg' => 'bg-green-50 dark:bg-green-900/20','text' => 'text-green-600 dark:text-green-400', 'border' => 'border-green-200 dark:border-green-700', 'badge' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'],
                                    default    => ['bg' => 'bg-gray-50',  'text' => 'text-gray-600',  'border' => 'border-gray-200',  'badge' => 'bg-gray-100 text-gray-700'],
                                };
                            @endphp
                            <div class="border {{ $statusColor['border'] }} rounded-xl overflow-hidden">
                                {{-- Header kartu --}}
                                <div class="{{ $statusColor['bg'] }} px-4 py-3 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <p class="font-bold text-sm text-gray-800 dark:text-white">
                                                {{ $laporan->checkingFixture?->part_number ?? '-' }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $laporan->checkingFixture?->nama_cf ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $statusColor['badge'] }}">
                                            {{ $laporan->status }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            {{ $laporan->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Body kartu --}}
                                <div class="px-4 py-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Kiri: keterangan + catatan admin --}}
                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Keterangan Kerusakan</p>
                                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $laporan->keterangan }}</p>
                                        </div>

                                        @if($laporan->catatan_admin)
                                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg p-3">
                                                <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 mb-1 flex items-center gap-1">
                                                    <x-heroicon-m-chat-bubble-left-right class="w-3.5 h-3.5" />
                                                    Catatan Admin
                                                </p>
                                                <p class="text-sm text-blue-700 dark:text-blue-300">{{ $laporan->catatan_admin }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Kanan: foto --}}
                                    <div>
                                        @if($laporan->foto_path)
                                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Foto Kerusakan</p>
                                            <a href="{{ Storage::disk('public')->url($laporan->foto_path) }}" target="_blank">
                                                <img
                                                    src="{{ Storage::disk('public')->url($laporan->foto_path) }}"
                                                    alt="Foto kerusakan"
                                                    class="w-full max-h-48 object-cover rounded-lg border border-gray-200 dark:border-gray-700 hover:opacity-90 transition-opacity cursor-pointer"
                                                />
                                                <p class="text-xs text-gray-400 mt-1 text-center">Klik untuk memperbesar</p>
                                            </a>
                                        @else
                                            <div class="flex items-center justify-center h-32 bg-gray-100 dark:bg-gray-800 rounded-lg border border-dashed border-gray-300 dark:border-gray-600">
                                                <p class="text-xs text-gray-400">Tidak ada foto</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <x-filament::icon icon="heroicon-o-clipboard-document-list" class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3 mx-auto" />
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada laporan</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Laporan yang Anda kirim akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-filament-panels::page>