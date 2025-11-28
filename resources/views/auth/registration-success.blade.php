<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil - MartPlace</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .success-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .header .icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .success-message {
            color: #27ae60;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .description {
            color: #2c3e50;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
            border-left: 4px solid #27ae60;
        }
        
        .info-box h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .info-box p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        
        .timeline {
            background: #e8f4fd;
            border: 1px solid #bee5eb;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
            color: #0c5460;
        }
        
        .timeline h3 {
            margin-bottom: 20px;
            color: #0c5460;
            font-size: 18px;
        }
        
        .timeline-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #d1ecf1;
        }
        
        .timeline-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .timeline-step {
            background: #17a2b8;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .timeline-content h4 {
            margin: 0 0 5px;
            color: #0c5460;
            font-size: 16px;
        }
        
        .timeline-content p {
            margin: 0;
            font-size: 14px;
            color: #6c757d;
        }
        
        .important-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            color: #856404;
        }
        
        .important-note h4 {
            margin-bottom: 10px;
            color: #856404;
        }
        
        .actions {
            margin-top: 40px;
            text-align: center;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin: 5px 10px;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        
        .footer {
            background: #2c3e50;
            color: white;
            padding: 20px 30px;
            text-align: center;
            font-size: 14px;
        }
        
        .footer a {
            color: #3498db;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 600px) {
            .success-container {
                margin: 10px;
            }
            
            .header, .content, .footer {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .header .icon {
                font-size: 50px;
            }
            
            .timeline-item {
                flex-direction: column;
                text-align: center;
            }
            
            .timeline-step {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="header">
            <div class="icon">✅</div>
            <h1>Registrasi Berhasil!</h1>
            <p>Terima kasih telah mendaftar sebagai penjual</p>
        </div>
        
        <div class="content">
            <div class="success-message">
                Selamat! Data registrasi Anda telah berhasil disimpan.
            </div>
            
            <div class="description">
                <p>Akun Anda sedang dalam proses <strong>verifikasi oleh tim admin</strong>. Kami akan meninjau kelengkapan dokumen dan data yang Anda berikan.</p>
            </div>
            
            <div class="info-box">
                <h3>📋 Yang Akan Kami Verifikasi:</h3>
                <p>✓ Kelengkapan data toko dan pemilik</p>
                <p>✓ Validitas dokumen KTP</p>
                <p>✓ Kesesuaian alamat dan kontak</p>
                <p>✓ Foto dan file dokumen yang diupload</p>
            </div>
            
            <div class="timeline">
                <h3>🕒 Proses Selanjutnya:</h3>
                
                <div class="timeline-item">
                    <div class="timeline-step">1</div>
                    <div class="timeline-content">
                        <h4>Verifikasi Dokumen</h4>
                        <p>Tim admin akan meninjau kelengkapan dan keabsahan dokumen Anda</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-step">2</div>
                    <div class="timeline-content">
                        <h4>Proses Review</h4>
                        <p>Membutuhkan waktu <strong>1-3 hari kerja</strong> untuk verifikasi lengkap</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-step">3</div>
                    <div class="timeline-content">
                        <h4>Email Konfirmasi</h4>
                        <p>Anda akan menerima email berisi hasil verifikasi (diterima/ditolak)</p>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-step">4</div>
                    <div class="timeline-content">
                        <h4>Mulai Berjualan</h4>
                        <p>Jika disetujui, Anda dapat langsung login dan mulai upload produk</p>
                    </div>
                </div>
            </div>
            
            <div class="important-note">
                <h4>⚠️ Hal Penting:</h4>
                <ul style="padding-left: 20px; margin: 10px 0;">
                    <li>Pastikan email Anda aktif untuk menerima notifikasi</li>
                    <li>Siapkan dokumen tambahan jika diminta oleh admin</li>
                    <li>Jangan mendaftar ulang selama proses verifikasi berlangsung</li>
                    <li>Hubungi customer service jika tidak ada kabar setelah 3 hari kerja</li>
                </ul>
            </div>
            
            <div class="actions">
                <a href="{{ url('/products') }}" class="btn btn-primary">🏠 Kembali ke Beranda</a>
                <a href="mailto:support@martplace.com" class="btn btn-secondary">📧 Hubungi Support</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Butuh bantuan? <a href="mailto:support@martplace.com">Hubungi Customer Service</a></p>
            <p>&copy; {{ date('Y') }} MartPlace. Platform Jual Beli Terpercaya.</p>
        </div>
    </div>
</body>
</html>