<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Riwayat Checking Fixture</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1a1a2e;
            background: #fff;
        }

        /* ── Page Layout ─────────────────────────────── */
        .page {
            padding: 24px 32px;
        }

        /* ── Header ──────────────────────────────────── */
        .header {
            display: table;
            width: 100%;
            border-bottom: 3px solid #ff7900;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }
        .header-logo {
            display: table-cell;
            width: 160px;
            vertical-align: middle;
        }
        .header-logo img {
            width: 140px;
            height: auto;
        }
        .header-info {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }
        .header-info .company {
            font-size: 11px;
            color: #555;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .header-info .doc-title {
            font-size: 17px;
            font-weight: bold;
            color: #1a1a2e;
            margin-top: 2px;
        }
        .header-info .doc-sub {
            font-size: 10px;
            color: #888;
            margin-top: 1px;
        }

        /* ── Meta Info Box ───────────────────────────── */
        .meta-box {
            background: #f8f9fc;
            border: 1px solid #e0e4ef;
            border-left: 4px solid #ff7900;
            border-radius: 4px;
            padding: 10px 14px;
            margin-bottom: 18px;
            display: table;
            width: 100%;
        }
        .meta-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            font-size: 10.5px;
            color: #444;
            line-height: 1.7;
        }
        .meta-label {
            color: #888;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .meta-value {
            font-weight: bold;
            color: #1a1a2e;
        }

        /* ── Table ───────────────────────────────────── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }
        thead tr {
            background-color: #1a1a2e;
            color: #fff;
        }
        thead th {
            padding: 9px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
            border: none;
        }
        tbody tr:nth-child(even) {
            background-color: #f5f7fb;
        }
        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #e8eaf0;
            vertical-align: top;
            color: #333;
        }
        .td-no {
            width: 4%;
            text-align: center;
            color: #888;
            font-size: 10px;
        }
        .td-cf {
            width: 24%;
        }
        .cf-part {
            font-weight: bold;
            color: #1a1a2e;
            font-size: 11px;
        }
        .cf-name {
            color: #777;
            font-size: 9.5px;
            margin-top: 2px;
        }
        .td-user { width: 20%; }
        .td-status { width: 17%; text-align: center; }
        .td-tanggal { width: 22%; }

        /* ── Status Badge ────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 9.5px;
            font-weight: bold;
            letter-spacing: 0.2px;
        }
        .badge-tersedia      { background: #d1fae5; color: #065f46; }
        .badge-digunakan     { background: #dbeafe; color: #1e40af; }
        .badge-perbaikan     { background: #fef9c3; color: #854d0e; }
        .badge-kalibrasi     { background: #ede9fe; color: #5b21b6; }
        .badge-eksternal     { background: #fee2e2; color: #991b1b; }

        /* ── Footer ──────────────────────────────────── */
        .footer {
            margin-top: 24px;
            border-top: 1px solid #dde0ec;
            padding-top: 10px;
            display: table;
            width: 100%;
        }
        .footer-left {
            display: table-cell;
            font-size: 9px;
            color: #aaa;
            vertical-align: bottom;
        }
        .footer-sign {
            display: table-cell;
            text-align: right;
            font-size: 10px;
            color: #555;
            vertical-align: top;
            width: 200px;
        }
        .footer-sign .sign-line {
            margin-top: 52px;
            border-top: 1px solid #666;
            padding-top: 4px;
            font-size: 9px;
            color: #888;
        }
        .orange { color: #ff7900; }
    </style>
</head>
<body>
<div class="page">

    {{-- ─── Header ─────────────────────────────────────── --}}
    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('nifco-logo-full.svg') }}" alt="NIFCO Logo">
        </div>
        <div class="header-info">
            <div class="company">PT. Nifco Indonesia</div>
            <div class="doc-title">Laporan Riwayat Transaksi</div>
            <div class="doc-sub">Sistem Informasi Inventaris Checking Fixture</div>
        </div>
    </div>

    {{-- ─── Meta Info ──────────────────────────────────── --}}
    <div class="meta-box">
        <div class="meta-col">
            <div class="meta-label">Nomor Dokumen</div>
            <div class="meta-value">DOC/QC/{{ now()->format('Ymd') }}/{{ str_pad($riwayat->count(), 3, '0', STR_PAD_LEFT) }}</div>
            <div style="margin-top:6px">
                <div class="meta-label">Jumlah Data</div>
                <div class="meta-value">{{ $riwayat->count() }} Transaksi</div>
            </div>
        </div>
        <div class="meta-col" style="text-align:right">
            <div class="meta-label">Tanggal Cetak</div>
            <div class="meta-value">{{ $tanggal_cetak }} WIB</div>
            <div style="margin-top:6px">
                <div class="meta-label">Dicetak Oleh</div>
                <div class="meta-value">{{ auth()->user()?->nama ?? 'System' }}</div>
            </div>
        </div>
    </div>

    {{-- ─── Tabel ──────────────────────────────────────── --}}
    <table>
        <thead>
            <tr>
                <th class="td-no">No</th>
                <th class="td-cf">Checking Fixture</th>
                <th class="td-user">User / Karyawan</th>
                <th class="td-status">Status Transaksi</th>
                <th class="td-tanggal">Tanggal & Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $index => $item)
                @php
                    $status = $item->jenis_transaksi ?? $item->status_transaksi ?? '-';
                    $badgeClass = match($status) {
                        'Tersedia'        => 'badge-tersedia',
                        'Digunakan'       => 'badge-digunakan',
                        'Perbaikan'       => 'badge-perbaikan',
                        'Kalibrasi'       => 'badge-kalibrasi',
                        'Dibawa Eksternal'=> 'badge-eksternal',
                        default           => '',
                    };
                @endphp
                <tr>
                    <td class="td-no">{{ $index + 1 }}</td>
                    <td class="td-cf">
                        <div class="cf-part">{{ $item->checkingFixture?->part_number ?? '-' }}</div>
                        <div class="cf-name">{{ $item->checkingFixture?->nama_cf ?? '-' }}</div>
                    </td>
                    <td class="td-user">{{ $item->user?->name ?? $item->user?->nama ?? '-' }}</td>
                    <td class="td-status">
                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                    </td>
                    <td class="td-tanggal">
                        {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->timezone('Asia/Jakarta')->format('d M Y') }}<br>
                        <span style="color:#888;font-size:9.5px">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->timezone('Asia/Jakarta')->format('H:i') }} WIB</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:20px; color:#aaa;">
                        Tidak ada data transaksi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ─── Footer ─────────────────────────────────────── --}}
    <div class="footer">
        <div class="footer-left">
            Dokumen ini digenerate secara otomatis oleh Sistem Informasi Inventaris Checking Fixture<br>
            &copy; {{ now()->year }} PT. Nifco Indonesia &mdash; <span class="orange">Confidential</span>
        </div>
        <div class="footer-sign">
            Mengetahui,<br>
            <strong>Kepala Departemen QC</strong>
            <div class="sign-line">Nama &amp; Tanda Tangan</div>
        </div>
    </div>

</div>
</body>
</html>