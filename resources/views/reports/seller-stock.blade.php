<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Daftar Produk Berdasarkan Stock</title>
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
        .row-dots {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Format Laporan Bagian Penjual (toko)</h1>
        <p style="margin-top: 10px;">(SRS-MartPlace-12)</p>
        <h2 style="margin-top: 15px;">Laporan Daftar Produk Berdasarkan Stock</h2>
        <p>Tanggal dibuat: {{ $date }} {{ $time }} oleh {{ $processedBy }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">No</th>
                <th style="width: 28%;">Produk</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 20%;">Harga</th>
                <th style="width: 12%;">Rating</th>
                <th style="width: 12%;">Stock</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? 'XXXXXXXX' }}</td>
                <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($product->average_rating ?? 0, 1) }}</td>
                <td style="text-align: center;">{{ $product->stock }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data produk</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p class="note">***) urutkan berdasarkan stock</p>

    <div style="text-align: center; margin-top: 40px; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 10px;">
        <p style="margin: 5px 0;">Dokumen ini dibuat secara otomatis oleh sistem Nestica</p>
        <p style="margin: 5px 0;">© 2025 Nestica - Platform Marketplace Furniture</p>
    </div>
</body>
</html>
