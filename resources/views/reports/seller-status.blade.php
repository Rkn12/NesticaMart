<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Daftar Akun Penjual Berdasarkan Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #000;
            margin: 30px;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        .header h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        .header p {
            margin: 0;
            font-size: 12px;
        }
        .note {
            margin: 15px 0;
            font-size: 11px;
            font-style: italic;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        table th {
            background: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        table td {
            vertical-align: top;
        }
        .row-dots {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Daftar Akun Penjual Berdasarkan Status</h1>
        <p>Tanggal dibuat: {{ $date }} {{ $time }} oleh {{ $processedBy }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">No</th>
                <th style="width: 23%;">Nama User</th>
                <th style="width: 23%;">Nama PIC</th>
                <th style="width: 23%;">Nama Toko</th>
                <th style="width: 23%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $index => $seller)
                @php
                    // Determine display status: Active if approved AND is_active=true, otherwise Tidak Aktif
                    $displayStatus = ($seller->status === 'approved' && $seller->is_active) ? 'Aktif' : 'Tidak Aktif';
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $seller->owner_name ?? 'XXXXXX' }}</td>
                    <td>{{ $seller->pic_name ?? 'XXXXXXXX XXXX' }}</td>
                    <td>{{ $seller->store_name }}</td>
                    <td>{{ $displayStatus }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="note">***) urutkan berdasarkan status (aktif dulu baru tidak aktif)</p>

    <div style="text-align: center; margin-top: 40px; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 10px;">
        <p style="margin: 5px 0;">Dokumen ini dibuat secara otomatis oleh sistem Nestica</p>
        <p style="margin: 5px 0;">© 2025 Nestica - Platform Marketplace Furniture</p>
    </div>
</body>
</html>
