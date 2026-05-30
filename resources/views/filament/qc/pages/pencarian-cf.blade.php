<x-filament-panels::page>
    {{-- JIKA DATA CF BELUM DICARI / KOSONG (TAMPILAN SEARCH) --}}
    @if(!$cf)
        <div class="flex flex-col items-center justify-center min-h-[60vh] space-y-6">
            <div class="text-center space-y-2">
                <x-heroicon-o-magnifying-glass class="w-16 h-16 mx-auto text-[#ff7900]" />
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Pencarian Alat Ukur / Checking Fixture</h2>
                <p class="text-gray-500 dark:text-gray-400">Cari data Checking Fixture berdasarkan Part Number</p>
            </div>

            {{-- Form Pencarian Menggunakan Form Filament --}}
            <div class="w-full max-w-2xl space-y-4">

                {{-- RENDER DROPDOWN FILAMENT --}}
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm">
                    {{ $this->form }}
                </div>

                <button wire:click="cariAlat" class="w-full py-3 bg-[#ff7900] hover:bg-[#e06c00] text-white font-semibold rounded-lg shadow transition-colors flex items-center justify-center gap-2">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                    Cari Alat
                </button>
            </div>

            <div class="w-full max-w-2xl bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-200 dark:border-gray-700 flex items-start gap-3">
                <x-heroicon-o-information-circle class="w-6 h-6 text-gray-500 shrink-0" />
                <div>
                    <p class="font-semibold text-sm text-gray-700 dark:text-gray-300">Petunjuk</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Masukkan Part Number alat ukur (contoh: J0166) kemudian klik tombol "Cari Alat" untuk menampilkan detail informasi Checking Fixture.</p>
                </div>
            </div>
        </div>

    {{-- JIKA DATA CF KETEMU (TAMPILAN DETAIL & UPDATE) --}}
    @else
        <div class="space-y-6">

            {{-- Tombol Kembali — style Filament standard --}}
            <button wire:click="kembali" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                <x-heroicon-m-arrow-left class="w-4 h-4" />
                <span>Kembali</span>
            </button>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Card Info CF --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm">
                    <h3 class="text-base font-bold mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">Informasi Checking Fixture</h3>
                    <div class="grid grid-cols-[140px_12px_1fr] gap-y-3 text-sm">
                        <div class="font-medium text-gray-500 dark:text-gray-400">Part Number</div>
                        <div class="text-gray-400">:</div>
                        <div class="font-semibold">{{ $cf->part_number }}</div>

                        <div class="font-medium text-gray-500 dark:text-gray-400">Customer</div>
                        <div class="text-gray-400">:</div>
                        <div>{{ $cf->customer ?? '-' }}</div>

                        <div class="font-medium text-gray-500 dark:text-gray-400">Nama Part / CF</div>
                        <div class="text-gray-400">:</div>
                        <div>{{ $cf->nama_cf }}</div>

                        <div class="font-medium text-gray-500 dark:text-gray-400">Lokasi Rak</div>
                        <div class="text-gray-400">:</div>
                        <div>{{ $cf->lokasiRak?->nama_rak ?? 'Belum ada rak' }}</div>

                        <div class="font-medium text-gray-500 dark:text-gray-400">Status Saat Ini</div>
                        <div class="text-gray-400">:</div>
                        <div>
                            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full text-xs font-semibold">
                                {{ $cf->status_ketersediaan }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card Update Status --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm">
                    <h3 class="text-base font-bold mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">Update Status Alat</h3>
                    <form wire:submit.prevent="updateStatus" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Pilih Status Baru</label>
                            <select wire:model="statusBaru" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#ff7900] focus:border-[#ff7900] dark:bg-gray-800 dark:border-gray-600 dark:text-white text-sm" required>
                                <option value="">-- Pilih Status Baru --</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Digunakan">Digunakan</option>
                                <option value="Perbaikan">Perbaikan</option>
                                <option value="Kalibrasi">Kalibrasi</option>
                                <option value="Dibawa Eksternal">Dibawa Eksternal</option>
                            </select>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full py-2.5 bg-[#ff7900] hover:bg-[#e06c00] text-white font-semibold rounded-lg shadow transition-colors flex items-center justify-center gap-2 text-sm">
                                <x-heroicon-o-document-check class="w-4 h-4" />
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endif
</x-filament-panels::page>