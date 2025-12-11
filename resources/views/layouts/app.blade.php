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
            font-family: Arial, sans-serif;
            background: #FBFDF0;
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
            width: 240px;
            background: #FBFDF0;
            color: #483A2E;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            border-right: 1px solid #D5CDC2;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-header {
            padding: 40px 20px 20px 20px;
            border-bottom: 1px solid #D5CDC2;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-header .seller-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .sidebar-header .seller-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .sidebar-header .seller-info {
            flex: 1;
        }
        
        .sidebar-header h1 {
            font-size: 16px;
            margin-bottom: 3px;
            color: #483A2E;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .sidebar-header h1 img.logo {
            width: 24px;
            height: 24px;
        }
        
        .sidebar-header p {
            font-size: 12px;
            color: #7E991E;
        }
        
        .sidebar-menu {
            padding: 20px 0;
            flex: 1;
        }
        
        .menu-section {
            margin-bottom: 25px;
        }
        
        .menu-section-title {
            padding: 8px 20px;
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .menu-item {
            padding: 12px 20px;
            color: #483A2E;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            font-size: 14px;
        }
        
        .menu-item:hover {
            background: #EFCD77;
            border-left-color: #7E991E;
        }
        
        .menu-item.active {
            background: #EFCD77;
            border-left-color: #7E991E;
            font-weight: bold;
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
            display: inline-block;
        }
        
        .sidebar-logout {
            margin-top: auto;
            padding: 20px;
            border-top: 1px solid #D5CDC2;
        }
        
        .sidebar-logout .btn-logout {
            width: 100%;
            background: #483A2E;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .sidebar-logout .btn-logout:hover {
            background: #7E991E;
        }
        
        .top-banner {
            background: #7E991E;
            color: #FDFBF0;
            text-align: center;
            padding: 5px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .main-content {
            margin-left: 240px;
            width: calc(100% - 240px);
            min-height: 100vh;
            padding-top: 28px;
        }
        
        .navbar {
            background: transparent;
            padding: 0;
            box-shadow: none;
            display: none;
        }
        
        .navbar-title h2 {
            color: #483A2E;
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
            color: #483A2E;
        }
        
        .btn-logout {
            background: #483A2E;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        
        .btn-logout:hover {
            background: #7E991E;
        }
        
        .container {
            padding: 30px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(72, 58, 46, 0.08);
            margin-bottom: 20px;
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .card-header h3 {
            color: #483A2E;
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
            background: #7E991E;
            color: white;
        }
        
        .btn-primary:hover {
            background: #6A8018;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(126, 153, 30, 0.3);
        }
        
        .btn-success {
            background: #7E991E;
            color: white;
        }
        
        .btn-danger {
            background: #483A2E;
            color: white;
        }
        
        .btn-warning {
            background: #EFCD77;
            color: #483A2E;
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
            background: #EFCD77;
            color: #483A2E;
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
            border-color: #7E991E;
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
            background: #7E991E;
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
            border: 2px solid #D5CDC2;
            border-radius: 8px;
            text-decoration: none;
            color: #7E991E;
            font-weight: 500;
            transition: all 0.3s ease;
            background: white;
        }
        
        .pagination a:hover {
            background: #7E991E;
            color: white;
            border-color: #7E991E;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(126, 153, 30, 0.3);
        }
        
        .pagination span[aria-current="page"] {
            background: #7E991E;
            color: white;
            border-color: #7E991E;
            box-shadow: 0 4px 12px rgba(126, 153, 30, 0.4);
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
            @if(Auth::check())
                @if(Auth::user()->isPlatform())
                    <div class="seller-info">
                        <h1 style="font-size: 24px;">Nestica</h1>
                        <p style="color: #7E991E; font-weight: bold; font-size: 14px;">Platform Admin</p>
                    </div>
                @else
                    <div class="seller-info">
                        <h1>{{ Auth::user()->name }}</h1>
                        <p style="color: #7E991E; font-weight: bold; font-size: 12px;">Active Seller</p>
                    </div>
                @endif
            @else
                <div class="seller-info">
                    <h1 style="font-size: 24px;">Nestica</h1>
                    <p>Marketplace Indonesia</p>
                </div>
            @endif
        </div>
        <div class="sidebar-menu">
            @if(Auth::check() && Auth::user()->isPenjual())
                <!-- Menu Section -->
                <div class="menu-section">
                    <div class="menu-section-title">Menu</div>
                    <a href="/seller/dashboard" class="menu-item {{ Request::is('seller/dashboard*') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="/products" class="menu-item {{ Request::is('products*') ? 'active' : '' }}">
                        Homepage
                    </a>
                </div>
                
                <!-- Tools Section -->
                <div class="menu-section">
                    <div class="menu-section-title">Tools</div>
                    <a href="{{ route('seller.products') }}" class="menu-item {{ Request::is('seller/products') && !Request::is('seller/products/upload') ? 'active' : '' }}">
                        Products
                    </a>
                    <a href="{{ route('seller.products.upload.form') }}" class="menu-item {{ Request::is('seller/products/upload') ? 'active' : '' }}">
                        Upload Product
                    </a>
                    <a href="/reviews" class="menu-item {{ Request::is('reviews*') ? 'active' : '' }}">
                        Product Reviews
                    </a>
                    <a href="/seller/reports" class="menu-item {{ Request::is('seller/reports*') ? 'active' : '' }}">
                        Store Reports
                    </a>
                </div>
            @elseif(Auth::check() && Auth::user()->isPlatform())
                <!-- Menu Section untuk Platform Admin -->
                <div class="menu-section">
                    <div class="menu-section-title">Menu</div>
                    <a href="/dashboard/platform" class="menu-item {{ Request::is('dashboard/platform*') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="/products" class="menu-item {{ Request::is('products*') ? 'active' : '' }}">
                        Homepage
                    </a>
                </div>
                
                <!-- Tools Section untuk Platform Admin -->
                <div class="menu-section">
                    <div class="menu-section-title">Tools</div>
                    <a href="{{ route('admin.sellers.index') }}" class="menu-item {{ Request::is('admin/sellers*') && !Request::is('admin/sellers/report*') ? 'active' : '' }}">
                        Manage Sellers
                    </a>
                    <a href="/reviews" class="menu-item {{ Request::is('reviews*') ? 'active' : '' }}">
                        Product Reviews
                    </a>
                    <a href="/reports" class="menu-item {{ Request::is('reports*') ? 'active' : '' }}">
                        Platform Reports
                    </a>
                </div>
            @endif
        </div>
        
        @if(Auth::check())
        <div class="sidebar-logout">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
        @endif
    </div>
    
    <div class="main-content">
        <div class="top-banner">
            BRINGS WARMTH AND CHARACTER INTO EVERY CORNER OF YOUR HOME
        </div>
        
        <div class="container">
            @yield('content')
        </div>
    </div>
    
    @yield('extra-scripts')
</body>
</html>
