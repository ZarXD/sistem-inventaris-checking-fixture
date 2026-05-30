<x-filament-panels::page>
    {{-- ─── Header ──────────────────────────────────────────────────── --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                Selamat datang, <span class="font-semibold text-gray-700 dark:text-gray-300">{{ auth()->user()?->getFilamentName() }}</span>!
                Berikut ringkasan data Checking Fixture.
            </p>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 shadow-sm">
            <x-heroicon-o-calendar-days class="w-4 h-4" />
            {{ $now->translatedFormat('d M Y, H:i') }}
        </div>
    </div>

    {{-- ─── Stats Cards ─────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
        {{-- Total --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm flex flex-col gap-2 col-span-2 sm:col-span-1 lg:col-span-1">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total CF</span>
                <x-heroicon-o-rectangle-stack class="w-5 h-5 text-gray-400" />
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $total }}</div>
            <div class="text-xs text-gray-400">Total Data</div>
        </div>

        @php
            $statusIcons = [
                'Tersedia'       => ['icon' => 'heroicon-o-check-circle',    'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/20'],
                'Digunakan'      => ['icon' => 'heroicon-o-clock',           'color' => 'text-blue-500',    'bg' => 'bg-blue-50 dark:bg-blue-900/20'],
                'Perbaikan'      => ['icon' => 'heroicon-o-wrench-screwdriver','color' => 'text-yellow-500', 'bg' => 'bg-yellow-50 dark:bg-yellow-900/20'],
                'Kalibrasi'      => ['icon' => 'heroicon-o-beaker',          'color' => 'text-purple-500',  'bg' => 'bg-purple-50 dark:bg-purple-900/20'],
                'Dibawa Eksternal'=> ['icon' => 'heroicon-o-archive-box-arrow-down','color' => 'text-rose-500','bg' => 'bg-rose-50 dark:bg-rose-900/20'],
            ];
        @endphp

        @foreach ($stats as $status => $count)
            @php $cfg = $statusIcons[$status] ?? ['icon' => 'heroicon-o-question-mark-circle', 'color' => 'text-gray-400', 'bg' => '']; @endphp
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-4 shadow-sm flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide truncate">{{ $status }}</span>
                    <x-dynamic-component :component="$cfg['icon']" class="w-5 h-5 flex-shrink-0 {{ $cfg['color'] }}" />
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $count }}</div>
                <div class="text-xs text-gray-400">Total Data</div>
            </div>
        @endforeach
    </div>

    {{-- ─── Charts ──────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Donut Chart --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm">
            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-4">Distribusi Status Checking Fixture</h3>
            <div class="flex items-center gap-6">
                <div class="relative flex-shrink-0">
                    <canvas id="statusDonut" width="160" height="160"></canvas>
                </div>
                <div class="flex flex-col gap-2 text-sm flex-1 min-w-0">
                    @php
                        $donutColors = ['#10b981','#3b82f6','#eab308','#8b5cf6','#f43f5e'];
                        $donutTotal  = array_sum(array_values($stats->toArray()));
                    @endphp
                    @foreach ($stats as $status => $count)
                        @php $pct = $donutTotal > 0 ? round($count / $donutTotal * 100, 1) : 0; @endphp
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="w-3 h-3 rounded-sm flex-shrink-0" style="background:{{ $donutColors[$loop->index % count($donutColors)] }}"></span>
                            <span class="text-gray-600 dark:text-gray-400 truncate">{{ $status }}</span>
                            <span class="ml-auto text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">{{ $count }} ({{ $pct }}%)</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-5 shadow-sm">
            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-4">Checking Fixture per Lokasi Rak</h3>
            <canvas id="lokasiBar" height="160"></canvas>
        </div>

    </div>

    {{-- ─── Tabel Terbaru ───────────────────────────────────────────── --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200">Checking Fixture Terbaru</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                        <th class="px-4 py-3 text-left font-semibold">No</th>
                        <th class="px-4 py-3 text-left font-semibold">Part Number</th>
                        <th class="px-4 py-3 text-left font-semibold">Nama CF</th>
                        <th class="px-4 py-3 text-left font-semibold">Customer</th>
                        <th class="px-4 py-3 text-left font-semibold">Lokasi Rak</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Tanggal Input</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($recent as $i => $cf)
                        @php
                            $badgeMap = [
                                'Tersedia'        => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                'Digunakan'       => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                'Perbaikan'       => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'Kalibrasi'       => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                'Dibawa Eksternal'=> 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
                            ];
                            $badge = $badgeMap[$cf->status_ketersediaan] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-4 py-3 text-gray-400">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-200">{{ $cf->part_number }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $cf->nama_cf }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $cf->customer ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $cf->lokasiRak?->nama_rak ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                    {{ $cf->status_ketersediaan }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                {{ $cf->created_at?->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada data Checking Fixture</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <span class="text-xs text-gray-400">Menampilkan {{ $recent->count() }} dari {{ $total }} data</span>
            <a href="{{ \App\Filament\Resources\CheckingFixtures\CheckingFixtureResource::getUrl('index') }}"
               class="text-xs font-semibold text-[#ff7900] hover:text-[#e06c00] flex items-center gap-1 transition-colors">
                Lihat Semua
                <x-heroicon-m-arrow-right class="w-3.5 h-3.5" />
            </a>
        </div>
    </div>

    {{-- ─── Chart.js Scripts ────────────────────────────────────────── --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
            const labelColor = isDark ? '#9ca3af' : '#6b7280';

            // ── Donut Chart ──────────────────────────────────────────
            const donutCtx = document.getElementById('statusDonut');
            if (donutCtx) {
                new Chart(donutCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($stats->keys()),
                        datasets: [{
                            data: @json($stats->values()),
                            backgroundColor: ['#10b981','#3b82f6','#eab308','#8b5cf6','#f43f5e'],
                            borderWidth: 2,
                            borderColor: isDark ? '#111827' : '#ffffff',
                            hoverOffset: 6,
                        }]
                    },
                    options: {
                        cutout: '68%',
                        plugins: { legend: { display: false }, tooltip: { callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.raw} unit`
                        }}},
                    }
                });
            }

            // ── Bar Chart ────────────────────────────────────────────
            const barCtx = document.getElementById('lokasiBar');
            if (barCtx) {
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($lokasiData->pluck('nama_rak')),
                        datasets: [{
                            label: 'Jumlah CF',
                            data: @json($lokasiData->pluck('checking_fixtures_count')),
                            backgroundColor: '#ff7900cc',
                            borderColor: '#ff7900',
                            borderWidth: 1.5,
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { color: gridColor }, ticks: { color: labelColor, font: { size: 11 } } },
                            y: { grid: { color: gridColor }, ticks: { color: labelColor, font: { size: 11 }, precision: 0 }, beginAtZero: true },
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-filament-panels::page>
