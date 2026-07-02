<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Laporan Kerusakan Checking Fixture</title>
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

        /* ── Table ───────────────────────────────────── */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }
        table.data-table thead tr {
            color: #1a1a2e;
            border-bottom: 2px solid #1a1a2e;
        }
        table.data-table thead th {
            padding: 9px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
            border: none;
        }
        table.data-table tbody tr:nth-child(even) {
            background-color: #f5f7fb;
        }
        table.data-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        table.data-table tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #e8eaf0;
            vertical-align: top;
            color: #333;
        }
        .td-no { width: 4%; text-align: center; color: #888; font-size: 10px; }
        .td-cf { width: 22%; }
        .cf-part { font-weight: bold; color: #1a1a2e; font-size: 11px; }
        .cf-name { color: #777; font-size: 9.5px; margin-top: 2px; }
        .td-user { width: 18%; }
        .td-ket { width: 26%; }
        .td-status { width: 12%; text-align: center; }
        .td-tanggal { width: 18%; }

        /* ── Status Badge ────────────────────────────── */
        .badge {
            display: inline-block;
            font-size: 9.5px;
            font-weight: bold;
            letter-spacing: 0.2px;
            color: #000;
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
            <div class="doc-title">Daftar Laporan Kerusakan</div>
            <div class="doc-sub">Sistem Informasi Inventaris Checking Fixture</div>
        </div>
    </div>

    {{-- ─── Meta Info ──────────────────────────────────── --}}
    <div class="meta-box">
        <div class="meta-col">
            <div class="meta-label">Nomor Dokumen</div>
            <div class="meta-value">DOC/QC-RPT/{{ now()->format('Ymd') }}/{{ str_pad($laporan->count(), 3, '0', STR_PAD_LEFT) }}</div>
            <div style="margin-top:6px">
                <div class="meta-label">Jumlah Data</div>
                <div class="meta-value">{{ $laporan->count() }} Laporan</div>
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
    <table class="data-table">
        <thead>
            <tr>
                <th class="td-no">No</th>
                <th class="td-cf">Checking Fixture</th>
                <th class="td-user">Pelapor</th>
                <th class="td-ket">Keterangan Kerusakan</th>
                <th class="td-status">Status</th>
                <th class="td-tanggal">Tgl. Laporan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
                <tr>
                    <td class="td-no">{{ $index + 1 }}</td>
                    <td class="td-cf">
                        <div class="cf-part">{{ $item->checkingFixture?->part_number ?? '-' }}</div>
                        <div class="cf-name">{{ $item->checkingFixture?->nama_cf ?? '-' }}</div>
                    </td>
                    <td class="td-user">{{ $item->user?->name ?? $item->user?->nama ?? '-' }}</td>
                    <td class="td-ket">{{ \Illuminate\Support\Str::limit($item->keterangan, 80) }}</td>
                    <td class="td-status">
                        <span class="badge">{{ $item->status }}</span>
                    </td>
                    <td class="td-tanggal">
                        {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y') }}<br>
                        <span style="color:#888;font-size:9.5px">{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('H:i') }} WIB</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:20px; color:#aaa;">
                        Tidak ada data laporan kerusakan.
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
