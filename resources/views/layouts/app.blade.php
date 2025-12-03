<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Marketplace')</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
        }

        /* Select2 Customization */
        .select2-container .select2-selection--single {
            height: 42px !important;
            border: 1px solid #ddd !important;
            border-radius: 5px !important;
            padding: 6px !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
        
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .sidebar-header p {
            font-size: 13px;
            opacity: 0.8;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            display: block;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .menu-item:hover,
        .menu-item.active {
            background: rgba(255,255,255,0.1);
            border-left-color: white;
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
            display: inline-block;
        }
        
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
        }
        
        .navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-title h2 {
            color: #333;
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
            background: #e74c3c;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .btn-logout:hover {
            background: #c0392b;
        }
        
        .container {
            padding: 30px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .card-header h3 {
            color: #333;
            font-size: 20px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
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
        
        .btn-success {
            background: #27ae60;
            color: white;
        }
        
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        
        .btn-warning {
            background: #f39c12;
            color: white;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        table th {
            background: #f8f9fa;
            color: #555;
            font-weight: 600;
        }
        
        table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .alert {
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-card h3 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        
        .stat-card p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .search-bar input {
            flex: 1;
        }
        
        /* Pagination Styling */
        nav[role="navigation"] {
            margin-top: 30px;
        }
        
        nav[role="navigation"] div:first-child {
            display: none; /* Hide "Showing X to Y of Z results" */
        }
        
        .pagination {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .pagination a,
        .pagination span {
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-decoration: none;
            color: #667eea;
            font-weight: 500;
            transition: all 0.3s ease;
            background: white;
        }
        
        .pagination a:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }
        
        .pagination span[aria-current="page"] {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .pagination span[aria-disabled="true"] {
            opacity: 0.3;
            cursor: not-allowed;
            border-color: #e0e0e0;
            color: #999;
        }
        
        .pagination svg {
            display: none !important; /* Hide arrow icons */
            width: 0 !important;
            height: 0 !important;
            visibility: hidden !important;
        }
        
        .pagination a[rel="prev"],
        .pagination a[rel="next"] {
            font-size: 0; /* Hide any text inside */
        }
        
        .pagination a[rel="prev"]::before {
            content: "‹ Prev";
            font-size: 14px;
        }
        
        .pagination a[rel="next"]::before {
            content: "Next ›";
            font-size: 14px;
        }
    </style>
    @yield('extra-styles')
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>🛍️ MartPlace</h1>
            @if(Auth::check())
                <p>
                    @if(Auth::user()->isPlatform())
                        Platform Admin
                    @else
                        Dashboard Penjual
                    @endif
                </p>
            @else
                <p>Marketplace Indonesia</p>
            @endif
        </div>
        <div class="sidebar-menu">
            <!-- Menu untuk semua (guest & auth) -->
            <a href="/products" class="menu-item {{ Request::is('products*') ? 'active' : '' }}">
                <i>🛍️</i> Katalog Produk
            </a>
            <a href="/reviews" class="menu-item {{ Request::is('reviews*') ? 'active' : '' }}">
                <i>⭐</i> Review Produk
            </a>
            
            @if(Auth::check())
            <hr style="border: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            
            <a href="/dashboard" class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <i>📊</i> Dashboard
            </a>
            
            @if(Auth::user()->isPlatform())
                <!-- Menu untuk Platform Admin -->
                <a href="{{ route('admin.sellers.index') }}" class="menu-item {{ Request::is('admin/sellers*') && !Request::is('admin/sellers/report*') ? 'active' : '' }}">
                    <i>👥</i> Kelola Penjual
                </a>
                <a href="/dashboard/platform" class="menu-item {{ Request::is('dashboard/platform*') ? 'active' : '' }}">
                    <i>📈</i> Analytics Platform
                </a>
                <a href="/reports" class="menu-item {{ Request::is('reports*') ? 'active' : '' }}">
                    <i>📄</i> Laporan Platform
                </a>
            @endif
            
            @if(Auth::user()->isPenjual())
                <!-- Menu untuk Penjual -->
                <a href="{{ route('seller.products.upload.form') }}" class="menu-item {{ Request::is('seller/products/upload') ? 'active' : '' }}">
                    <i>➕</i> Upload Produk
                </a>
                <a href="/seller/dashboard" class="menu-item {{ Request::is('seller/dashboard*') ? 'active' : '' }}">
                    <i>📊</i> Dashboard Toko
                </a>
                <a href="/seller/reports" class="menu-item {{ Request::is('seller/reports*') ? 'active' : '' }}">
                    <i>📄</i> Laporan Toko
                </a>
            @endif
            @endif
        </div>
    </div>
    
    <div class="main-content">
        <nav class="navbar">
            <div class="navbar-title">
                <h2>@yield('page-title', 'Dashboard')</h2>
            </div>
            <div class="navbar-right">
                @if(Auth::check())
                    <div class="user-info">
                        <span>
                            @if(Auth::user()->role === 'penjual' && Auth::user()->seller)
                                {{ Auth::user()->seller->store_name }}
                            @else
                                {{ Auth::user()->name }}
                            @endif
                        </span>
                    </div>
                    <form action="{{ url('/logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                @else
                    <a href="/register" style="padding: 10px 20px; background: white; color: #667eea; border: 2px solid #667eea; border-radius: 8px; text-decoration: none; font-weight: 500; margin-right: 10px;">Daftar</a>
                    <a href="/login" style="padding: 10px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 500;">Login</a>
                @endif
            </div>
        </nav>
        
        <div class="container">
            @yield('content')
        </div>
    </div>
    
    @yield('extra-scripts')
</body>
</html>
