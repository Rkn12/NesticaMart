<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Penolakan - MartPlace</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .email-header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .message {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        
        .store-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #e74c3c;
        }
        
        .store-info h3 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .info-label {
            font-weight: 600;
            color: #666;
            width: 120px;
        }
        
        .info-value {
            color: #2c3e50;
            flex: 1;
        }
        
        .rejection-reason {
            background: #fee;
            border: 1px solid #fcc;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            color: #c00;
        }
        
        .rejection-reason h3 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #c00;
        }
        
        .next-steps {
            background: #e8f4fd;
            border: 1px solid #bee5eb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            color: #0c5460;
        }
        
        .next-steps h3 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #0c5460;
        }
        
        .re-register-button {
            text-align: center;
            margin: 30px 0;
        }
        
        .re-register-button a {
            display: inline-block;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            transition: all 0.3s ease;
        }
        
        .re-register-button a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }
        
        .email-footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
            font-size: 14px;
        }
        
        .email-footer p {
            margin: 5px 0;
            opacity: 0.8;
        }
        
        .contact-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #34495e;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .email-header,
            .email-body,
            .email-footer {
                padding: 20px;
            }
            
            .info-row {
                flex-direction: column;
            }
            
            .info-label {
                width: auto;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>📝 Pemberitahuan Registrasi</h1>
            <p>Status Permohonan Penjual</p>
        </div>
        
        <div class="email-body">
            <div class="message">
                <strong>Halo {{ $seller->owner_name }},</strong>
            </div>
            
            <p>Terima kasih atas minat Anda untuk bergabung sebagai penjual di MartPlace. Setelah meninjau permohonan registrasi Anda, kami dengan berat hati harus <strong>menunda persetujuan akun Anda</strong> untuk sementara waktu.</p>
            
            <div class="store-info">
                <h3>📋 Detail Registrasi</h3>
                <div class="info-row">
                    <span class="info-label">Nama Toko:</span>
                    <span class="info-value">{{ $seller->store_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nama PIC:</span>
                    <span class="info-value">{{ $seller->owner_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $seller->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Daftar:</span>
                    <span class="info-value">{{ $seller->created_at->format('d F Y, H:i') }} WIB</span>
                </div>
            </div>
            
            @if($rejectionReason)
            <div class="rejection-reason">
                <h3>❌ Alasan Penolakan</h3>
                <p>{{ $rejectionReason }}</p>
            </div>
            @endif
            
            <div class="next-steps">
                <h3>🔄 Langkah Selanjutnya</h3>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Perbaiki dokumen atau informasi sesuai dengan catatan di atas</li>
                    <li>Pastikan semua data yang dimasukkan sudah benar dan lengkap</li>
                    <li>Siapkan dokumen pendukung yang valid dan jelas</li>
                    <li>Daftar ulang dengan data yang sudah diperbaiki</li>
                </ul>
            </div>
            
            <p>Kami mengundang Anda untuk mendaftar kembali setelah melakukan perbaikan yang diperlukan:</p>
            
            <div class="re-register-button">
                <a href="{{ url('/register') }}" target="_blank">
                    🔄 Daftar Ulang Sekarang
                </a>
            </div>
            
            <p style="margin-top: 30px;">Jika Anda memiliki pertanyaan atau membutuhkan klarifikasi lebih lanjut, jangan ragu untuk menghubungi tim customer service kami.</p>
            
            <p><em>Kami berharap dapat bekerja sama dengan Anda di masa mendatang.</em></p>
        </div>
        
        <div class="email-footer">
            <p><strong>Tim MartPlace</strong></p>
            <p>Platform Jual Beli Terpercaya</p>
            
            <div class="contact-info">
                <p>📧 support@martplace.com | 📞 0800-123-4567</p>
                <p>🌐 www.martplace.com</p>
            </div>
        </div>
    </div>
</body>
</html>