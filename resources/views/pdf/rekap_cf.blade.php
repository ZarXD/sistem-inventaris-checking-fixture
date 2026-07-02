<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Rekap Checking Fixture</title>
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
            /* Padding bawah 80px buat ngasih ruang ke footer (teks copyright) */
            padding: 24px 32px 80px 32px;
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

        /* ── Section Title ───────────────────────────── */
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #ff7900;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #ffe0c0;
        }

        /* ── Ringkasan Stats ─────────────────────────── */
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .stats-table td {
            padding: 7px 12px;
            border: 1px solid #e8eaf0;
            font-size: 10.5px;
        }
        .stats-table tr:nth-child(even) td {
            background-color: #f5f7fb;
        }
        .stats-label {
            width: 60%;
            color: #444;
        }
        .stats-value {
            width: 20%;
            text-align: center;
            font-weight: bold;
            color: #1a1a2e;
        }
        .stats-pct {
            width: 20%;
            text-align: center;
            color: #888;
            font-size: 10px;
        }
        .stats-header td {
            color: #1a1a2e;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            /* Disesuaikan jadi 2px atas & bawah biar seragam sama tabel detail */
            border-top: 2px solid #1a1a2e !important;
            border-bottom: 2px solid #1a1a2e !important;
            border-left: 1px solid #e8eaf0;
            border-right: 1px solid #e8eaf0;
        }
        .stats-total td {
            background-color: #fff3e0 !important;
            font-weight: bold;
            color: #c05000;
            border-color: #ffc080;
        }

        /* ── Detail Table ────────────────────────────── */
        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 20px;
        }
        table.detail-table thead th {
            padding: 9px 10px;
            text-align: left;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
            /* Disesuaikan jadi 2px atas & bawah */
            border-top: 2px solid #1a1a2e;
            border-bottom: 2px solid #1a1a2e;
            border-left: none;
            border-right: none;
            color: #1a1a2e;
        }
        table.detail-table tbody tr:nth-child(even) {
            background-color: #f5f7fb;
        }
        table.detail-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        table.detail-table tbody td {
            padding: 7px 9px;
            border-bottom: 1px solid #e8eaf0;
            vertical-align: middle;
            color: #333;
        }
        .td-no    { width: 4%;  text-align: center; color: #888; font-size: 9.5px; }
        .td-part  { width: 18%; font-weight: bold; color: #1a1a2e; }
        .td-nama  { width: 25%; }
        .td-cust  { width: 18%; }
        .td-lok   { width: 15%; }
        .td-status{ width: 20%; text-align: center; }

        /* ── Status Badge ────────────────────────────── */
        .badge {
            display: inline-block;
            font-size: 9.5px;
            font-weight: bold;
            letter-spacing: 0.2px;
            color: #1a1a2e;
        }

        /* ── Area Tanda Tangan (Nempel setelah tabel) ── */
        .signature-container {
            margin-top: 40px;
            width: 100%;
            text-align: right; /* Supaya kotaknya lari ke kanan */
        }
        .signature-box {
            display: inline-block;
            width: 200px;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
        .signature-box .sign-line {
            margin-top: 60px;
            border-top: 1px solid #666;
            padding-top: 4px;
            font-size: 9px;
            color: #888;
        }

        /* ── Footer Khusus Copyright (Fixed di bawah) ── */
        .footer {
            position: fixed; 
            bottom: 24px;    
            left: 32px;      
            right: 32px;     
            border-top: 1px solid #dde0ec;
            padding-top: 10px;
            font-size: 9px;
            color: #aaa;
        }
        .orange { color: #ff7900; }
    </style>
</head>
<body>

{{-- ─── Footer ditaruh di luar page biar jadi template tiap halaman ─── --}}
<div class="footer">
    Dokumen ini digenerate secara otomatis oleh Sistem Informasi Inventaris Checking Fixture<br>
    &copy; {{ now()->year }} PT. Nifco Indonesia &mdash; <span class="orange">Confidential</span>
</div>

<div class="page">

    {{-- ─── Header ─────────────────────────────────────── --}}
    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('nifco-logo-full.svg') }}" alt="NIFCO Logo">
        </div>
        <div class="header-info">
            <div class="company">PT. Nifco Indonesia</div>
            <div class="doc-title">Laporan Rekap Checking Fixture</div>
            <div class="doc-sub">Sistem Informasi Inventaris Checking Fixture</div>
        </div>
    </div>

    {{-- ─── Meta Info ──────────────────────────────────── --}}
    <div class="meta-box">
        <div class="meta-col">
            <div class="meta-label">Nomor Dokumen</div>
            <div class="meta-value">DOC/QC/{{ now()->format('Ymd') }}/RKP</div>
            <!-- <div style="margin-top:6px">
                <div class="meta-label">Filter Diterapkan</div>
                <div class="meta-value">{{ $filter_label }}</div>
            </div> -->
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

    {{-- ─── Ringkasan Status ────────────────────────────── --}}
    <div class="section-title">Ringkasan Status Checking Fixture</div>
    @php $total = array_sum($ringkasan); @endphp
    <table class="stats-table">
        <thead>
            <tr class="stats-header">
                <td class="stats-label">Status Ketersediaan</td>
                <td class="stats-value">Jumlah</td>
                <td class="stats-pct">Persentase</td>
            </tr>
        </thead>
        <tbody>
            @foreach($ringkasan as $status => $jumlah)
                @php
                    $pct = $total > 0 ? round(($jumlah / $total) * 100, 1) : 0;
                @endphp
                <tr>
                    <td class="stats-label">{{ $status }}</td>
                    <td class="stats-value">{{ $jumlah }}</td>
                    <td class="stats-pct">{{ $pct }}%</td>
                </tr>
            @endforeach
            <tr class="stats-total">
                <td class="stats-label">TOTAL</td>
                <td class="stats-value">{{ $total }}</td>
                <td class="stats-pct">100%</td>
            </tr>
        </tbody>
    </table>

    {{-- ─── Detail Checking Fixture ─────────────────────── --}}
    <div class="section-title">Detail Checking Fixture</div>
    <table class="detail-table">
        <thead>
            <tr>
                <th class="td-no">No</th>
                <th class="td-part">Part Number</th>
                <th class="td-nama">Nama CF</th>
                <th class="td-cust">Customer</th>
                <th class="td-lok">Lokasi Rak</th>
                <th class="td-status">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td class="td-no">{{ $index + 1 }}</td>
                    <td class="td-part">{{ $item->part_number ?? '-' }}</td>
                    <td class="td-nama">{{ $item->nama_cf ?? '-' }}</td>
                    <td class="td-cust">{{ $item->customer ?? '-' }}</td>
                    <td class="td-lok">{{ $item->lokasiRak?->nama_rak ?? '-' }}</td>
                    <td class="td-status">
                        <span class="badge">{{ $item->status_ketersediaan }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:20px; color:#aaa;">
                        Tidak ada data checking fixture.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ─── Area Tanda Tangan (Nempel di bawah tabel) ────────── --}}
    <div class="signature-container">
        <div class="signature-box">
            Mengetahui,<br>
            <strong>Kepala Departemen QC</strong>
            <div class="sign-line">Nama &amp; Tanda Tangan</div>
        </div>
    </div>

</div>
</body>
</html>