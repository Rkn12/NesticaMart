<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Daftar Toko Berdasarkan Lokasi Propinsi</title>
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
        .row-dots {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>(SRS-MartPlace-10)</p>
        <h2>Laporan Daftar Toko Berdasarkan Lokasi Propinsi</h2>
        <p>Tanggal dibuat: {{ $date }} {{ $time }} oleh {{ $processedBy }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">No</th>
                <th style="width: 30%;">Nama Toko</th>
                <th style="width: 31%;">Nama PIC</th>
                <th style="width: 31%;">Propinsi</th>
            </tr>
        </thead>
        <tbody>
            @php $globalIndex = 1; @endphp
            @foreach($sellers_by_province as $province => $sellers)
                @foreach($sellers as $index => $seller)
                    <tr>
                        <td style="text-align: center;">{{ $globalIndex++ }}</td>
                        <td>{{ $seller->store_name }}</td>
                        <td>{{ $seller->pic_name ?? 'XXXXXXXX XXXX' }}</td>
                        <td>{{ $province }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <p class="note">***) Diurutkan berdasarkan propinsi</p>

    <div style="text-align: center; margin-top: 40px; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 10px;">
        <p style="margin: 5px 0;">Dokumen ini dibuat secara otomatis oleh sistem Nestica</p>
        <p style="margin: 5px 0;">© 2025 Nestica - Platform Marketplace Furniture</p>
    </div>
</body>
</html>
