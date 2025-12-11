<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat! Akun Disetujui - MartPlace</title>
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
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .header-icon {
            font-size: 60px;
            margin-bottom: 20px;
            display: block;
        }
        
        .email-header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .email-header p {
            margin: 10px 0 0;
            font-size: 18px;
            opacity: 0.95;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .welcome-message {
            font-size: 20px;
            color: #27ae60;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .store-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
            border-left: 5px solid #27ae60;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .store-info h3 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 20px;
            display: flex;
            align-items: center;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #666;
            width: 140px;
        }
        
        .info-value {
            color: #2c3e50;
            flex: 1;
            font-weight: 500;
        }
        
        .credentials-box {
            background: linear-gradient(135deg, #667eea 0%, #658168ff 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
            text-align: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .credentials-box h3 {
            margin: 0 0 15px;
            font-size: 18px;
        }
        
        .credentials-box .creds {
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 30px 0;
        }
        
        .feature-item {
            background: #f8f9fa;
            padding: 20px 15px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .feature-item:hover {
            border-color: #27ae60;
            transform: translateY(-2px);
        }
        
        .feature-item .icon {
            font-size: 32px;
            margin-bottom: 10px;
            display: block;
        }
        
        .feature-item h4 {
            margin: 0 0 8px;
            color: #2c3e50;
            font-size: 14px;
        }
        
        .feature-item p {
            margin: 0;
            color: #666;
            font-size: 12px;
        }
        
        .login-button {
            text-align: center;
            margin: 35px 0;
        }
        
        .login-button a {
            display: inline-block;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 18px 45px;
            text-decoration: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
            transition: all 0.3s ease;
        }
        
        .login-button a:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(46, 204, 113, 0.5);
        }
        
        .important-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            color: #856404;
            font-size: 14px;
        }
        
        .important-note h4 {
            margin: 0 0 10px;
            color: #856404;
        }
        
        .next-steps {
            background: linear-gradient(135deg, #e8f4fd 0%, #d1ecf1 100%);
            border: 1px solid #bee5eb;
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
            color: #0c5460;
        }
        
        .next-steps h3 {
            margin: 0 0 15px;
            color: #0c5460;
            font-size: 18px;
        }
        
        .next-steps ol {
            margin: 0;
            padding-left: 20px;
        }
        
        .next-steps li {
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .email-footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 30px;
            text-align: center;
            font-size: 14px;
        }
        
        .email-footer h3 {
            margin: 0 0 15px;
            font-size: 20px;
        }
        
        .email-footer p {
            margin: 5px 0;
            opacity: 0.9;
        }
        
        .contact-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #495057;
        }
        
        .social-links {
            margin-top: 15px;
        }
        
        .social-links a {
            color: #3498db;
            text-decoration: none;
            margin: 0 10px;
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
            
            .features-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .email-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <span class="header-icon">🎉</span>
            <h1>Selamat!</h1>
            <p>Akun Penjual Anda Telah Disetujui</p>
        </div>
        
        <div class="email-body">
            <div class="welcome-message">
                Halo {{ $seller->owner_name }}! 🎊
            </div>
            
            <p style="text-align: center; font-size: 16px; color: #2c3e50; margin-bottom: 30px;">
                Selamat! Tim admin MartPlace telah <strong>menyetujui</strong> pendaftaran toko Anda. 
                Sekarang Anda resmi menjadi bagian dari keluarga penjual MartPlace!
            </p>
            
            <div class="store-info">
                <h3>🏪 Informasi Toko Anda</h3>
                <div class="info-row">
                    <span class="info-label">Nama Toko:</span>
                    <span class="info-value">{{ $seller->store_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pemilik:</span>
                    <span class="info-value">{{ $seller->owner_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $seller->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Lokasi:</span>
                    <span class="info-value">{{ $seller->city }}, {{ $seller->province }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value" style="color: #27ae60; font-weight: bold;">✅ DISETUJUI</span>
                </div>
            </div>
            
            <div class="credentials-box">
                <h3>🔐 Informasi Login Anda</h3>
                <div class="creds">{!! nl2br(e($credentials)) !!}</div>
                <p style="margin: 15px 0 0; font-size: 14px; opacity: 0.9;">
                    ⚠️ Silakan ubah password setelah login pertama untuk keamanan
                </p>
            </div>
            
            <div class="next-steps">
                <h3>🚀 Langkah Selanjutnya</h3>
                <ol>
                    <li>Login ke dashboard penjual</li>
                    <li>Lengkapi profil toko Anda</li>
                    <li>Upload produk sesuai kategori</li>
                    <li>Atur harga dan stok produk</li>
                    <li>Mulai berjualan!</li>
                </ol>
            </div>
            
            <div class="features-grid">
                <div class="feature-item">
                    <span class="icon">📦</span>
                    <h4>Upload Produk</h4>
                    <p>Tambahkan produk dengan mudah</p>
                </div>
                <div class="feature-item">
                    <span class="icon">📊</span>
                    <h4>Dashboard</h4>
                    <p>Kelola toko secara real-time</p>
                </div>
                <div class="feature-item">
                    <span class="icon">📈</span>
                    <h4>Laporan</h4>
                    <p>Analisis penjualan mendalam</p>
                </div>
                <div class="feature-item">
                    <span class="icon">💬</span>
                    <h4>Rating & Review</h4>
                    <p>Interaksi dengan pembeli</p>
                </div>
            </div>
            
            <div class="login-button">
                <a href="{{ url('/login') }}" target="_blank">
                    🚪 Masuk ke Dashboard
                </a>
            </div>
            
            <div class="important-note">
                <h4>📌 Hal Penting:</h4>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Pastikan produk yang diupload sesuai dengan kategori</li>
                    <li>Gunakan foto produk yang berkualitas tinggi</li>
                    <li>Berikan deskripsi yang jelas dan lengkap</li>
                    <li>Tanggapi review dan pertanyaan pembeli dengan baik</li>
                </ul>
            </div>
            
            <p style="text-align: center; font-size: 16px; color: #2c3e50; margin-top: 30px;">
                <strong>Selamat berjualan dan sukses selalu! 🌟</strong>
            </p>
        </div>
        
        <div class="email-footer">
            <h3>🏪 Tim MartPlace</h3>
            <p>Platform Jual Beli Terpercaya Indonesia</p>
            
            <div class="contact-info">
                <p>📧 support@martplace.com | 📞 0800-123-4567</p>
                <p>🌐 www.martplace.com</p>
                
                <div class="social-links">
                    <a href="#" target="_blank">Instagram</a> |
                    <a href="#" target="_blank">Facebook</a> |
                    <a href="#" target="_blank">Twitter</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>