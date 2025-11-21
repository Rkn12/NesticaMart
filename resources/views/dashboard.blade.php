<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Marketplace</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-logout {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .btn-logout:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card h2 {
            margin-bottom: 20px;
            color: #333;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-card h3 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .stat-card p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .menu-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
        }
        
        .menu-card:hover {
            border-color: #667eea;
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
        }
        
        .menu-card h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🛍️ Marketplace</h1>
        <div class="navbar-right">
            <div class="user-info">
                <span>Halo, {{ Auth::user()->name }}</span>
            </div>
            <form action="{{ url('/logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>
    
    <div class="container">
        <div class="stats">
            <div class="stat-card">
                <h3>8</h3>
                <p>Total Penjual</p>
            </div>
            <div class="stat-card">
                <h3>24+</h3>
                <p>Total Produk</p>
            </div>
            <div class="stat-card">
                <h3>10</h3>
                <p>Kategori</p>
            </div>
            <div class="stat-card">
                <h3>50+</h3>
                <p>Total Review</p>
            </div>
        </div>
        
        <div class="card">
            <h2>Menu Utama</h2>
            <div class="menu-grid">
                <a href="/sellers" class="menu-card">
                    <h3>👥 Kelola Penjual</h3>
                    <p>Lihat dan verifikasi penjual</p>
                </a>
                
                <a href="/products" class="menu-card">
                    <h3>📦 Kelola Produk</h3>
                    <p>Lihat katalog produk</p>
                </a>
                
                <a href="/dashboard" class="menu-card">
                    <h3>📊 Dashboard Platform</h3>
                    <p>Statistik dan grafik platform</p>
                </a>
                
                <a href="/reports/seller-status" class="menu-card">
                    <h3>📄 Laporan</h3>
                    <p>Generate laporan PDF</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
