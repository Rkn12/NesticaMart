<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Daftar Akun Penjual - {{ ucfirst($status) }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm 1.5cm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            margin-top: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #000;
            page-break-after: avoid;
        }
        
        .header h1 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .header h2 {
            font-size: 12px;
            color: #333;
            font-weight: normal;
            margin-bottom: 5px;
        }
        
        .header .date {
            font-size: 14px;
            color: #666;
            font-style: italic;
            margin-top: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-box {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background: #f9f9f9;
        }
        
        .info-box h3 {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .info-box p {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        
        .stats-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        
        .stat-item {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }
        
        .table-section {
            margin-top: 20px;
        }
        
        .table-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            text-align: center;
        }
        
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: left;
            font-size: 9px;
            vertical-align: top;
        }
        
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            color: #000;
            text-align: center;
        }
        
        tr {
            page-break-inside: avoid;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            padding-right: 5%;
            border-top: 1px solid #ddd;
            text-align: right;
            color: #666;
            font-size: 10px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Daftar Akun Penjual Berdasarkan Status</h1>
        <div class="date">Tanggal dibuat: {{ date('d-m-Y') }} oleh {{ auth()->user()->name }}</div>
    </div>
    
    <div class="table-section">
        <div class="table-title">Daftar Penjual - Status: {{ ucfirst($status) }}</div>
        
        @if(count($sellers) > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama User</th>
                    <th style="width: 25%;">Nama PIC</th>
                    <th style="width: 25%;">Nama Toko</th>
                    <th style="width: 20%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellers as $index => $user)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->seller->owner_name }}</td>
                    <td>{{ $user->seller->store_name }}</td>
                    <td style="text-align: justify;">
                        @if($user->seller->is_active)
                            Aktif
                        @else
                            Tidak Aktif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-data">
            📭 Tidak ada data penjual untuk status: <strong>{{ ucfirst($status) }}</strong>
        </div>
        @endif
    </div>
    
    <div class="footer">
        <p>Laporan digenerate secara otomatis oleh sistem pada {{ date('d F Y, H:i:s') }} WIB</p>
        <p>© {{ date('Y') }} Marketplace Platform</p>
    </div>
</body>
</html>