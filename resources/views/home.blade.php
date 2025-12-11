@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('extra-styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <div style="margin-bottom: 30px;">
        <h2 style="color: #333; margin-bottom: 10px;">
            @if(Auth::user()->role === 'penjual' && Auth::user()->seller)
                Selamat Datang, {{ Auth::user()->name }}! 👋
                <small style="font-size: 16px; color: #666; display: block; font-weight: normal;">
                    {{ Auth::user()->seller->store_name }}
                </small>
            @else
                Selamat Datang, {{ Auth::user()->name }}! 👋
            @endif
        </h2>
        <p style="color: #666;">
            @if(Auth::user()->isPlatform())
                Berikut adalah ringkasan platform marketplace
            @elseif(Auth::user()->isPenjual())
                @if(Auth::user()->seller)
                    Berikut adalah ringkasan untuk {{ Auth::user()->seller->store_name }}
                @else
                    Berikut adalah ringkasan toko Anda
                @endif
            @else
                Selamat berbelanja di marketplace kami
            @endif
        </p>
    </div>

    @if(Auth::user()->isPlatform())
        <!-- Dashboard Platform Admin -->
        @php
            $totalSellers = \App\Models\Seller::count();
            $totalProducts = \App\Models\Product::count();
            $totalReviews = \App\Models\ProductReview::count();
            $avgRating = \App\Models\Product::avg('average_rating') ?? 0;
        @endphp
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $totalSellers }}</h3>
                <p>Total Penjual</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>{{ $totalProducts }}</h3>
                <p>Total Produk</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>{{ $totalReviews }}</h3>
                <p>Total Review</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h3>{{ number_format($avgRating, 1) }}/5</h3>
                <p>Rata-rata Rating</p>
            </div>
        </div>
    @elseif(Auth::user()->isPenjual())
        <!-- Dashboard Penjual -->
        @php
            $sellerStats = \App\Models\Product::where('seller_id', Auth::user()->seller_id)
                ->selectRaw('COUNT(*) as total_products, SUM(stock) as total_stock, AVG(CASE WHEN average_rating > 0 THEN average_rating ELSE NULL END) as avg_rating')
                ->first();
            $totalReviews = \App\Models\ProductReview::whereHas('product', function($q) {
                $q->where('seller_id', Auth::user()->seller_id);
            })->count();
        @endphp
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $sellerStats->total_products ?? 0 }}</h3>
                <p>Produk Saya</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>{{ $sellerStats->total_stock ?? 0 }}</h3>
                <p>Total Stok</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>{{ $totalReviews }}</h3>
                <p>Review Diterima</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h3>{{ number_format($sellerStats->avg_rating ?? 0, 1) }}/5</h3>
                <p>Rating Toko</p>
            </div>
        </div>
    @else
        <!-- Dashboard Pengunjung -->
        @php
            $totalProducts = \App\Models\Product::count();
            $activeSellers = \App\Models\Seller::where('status', 'approved')->count();
            $myReviews = \App\Models\ProductReview::where('reviewer_email', Auth::user()->email)->count();
            $totalReviews = \App\Models\ProductReview::count();
        @endphp
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $totalProducts }}</h3>
                <p>Produk Tersedia</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>{{ $activeSellers }}</h3>
                <p>Toko Aktif</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>{{ $myReviews }}</h3>
                <p>Review Saya</p>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h3>{{ $totalReviews }}</h3>
                <p>Total Review</p>
            </div>
        </div>
    @endif
    
    @if(Auth::user()->isPlatform())
        <!-- Charts untuk Platform Admin -->
        @php
            $sellersStatus = \App\Models\Seller::selectRaw('
                SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected
            ')->first();
            
            $productsByCategory = \App\Models\Product::join('product_categories', 'products.category_id', '=', 'product_categories.id')
                ->select('product_categories.name as category', \DB::raw('COUNT(*) as total'))
                ->groupBy('product_categories.name')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();
            
            $storesByProvince = \App\Models\Seller::select('province', \DB::raw('COUNT(*) as total'))
                ->groupBy('province')
                ->orderBy('total', 'desc')
                ->get();
            
            // Jumlah pengunjung yang memberikan komentar dan rating
            $totalReviewers = \App\Models\ProductReview::distinct('reviewer_email')->count('reviewer_email');
            $reviewsByProvince = \App\Models\ProductReview::select('reviewer_province', \DB::raw('COUNT(DISTINCT reviewer_email) as total'))
                ->groupBy('reviewer_province')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get();
        @endphp
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="card">
                <h3 style="margin-bottom: 20px;">Status Penjual</h3>
                <canvas id="sellersChart" style="max-height: 250px;"></canvas>
            </div>
            
            <div class="card">
                <h3 style="margin-bottom: 20px;">Produk per Kategori (Top 5)</h3>
                <canvas id="categoryChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="card">
                <h3 style="margin-bottom: 20px;">Toko per Provinsi</h3>
                <canvas id="provinceChart" style="max-height: 300px;"></canvas>
            </div>
            
            <div class="card">
                <h3 style="margin-bottom: 20px;">Pengunjung yang Memberi Review (Top 10 Provinsi)</h3>
                <div style="text-align: center; margin-bottom: 15px;">
                    <p style="font-size: 32px; font-weight: bold; color: #667eea; margin: 0;">{{ $totalReviewers }}</p>
                    <p style="color: #999; margin: 0;">Total Unique Reviewers</p>
                </div>
                <canvas id="reviewersChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
        
        <script>
        // Sellers Status Chart
        const sellersCtx = document.getElementById('sellersChart').getContext('2d');
        new Chart(sellersCtx, {
            type: 'doughnut',
            data: {
                labels: ['Approved', 'Pending', 'Rejected'],
                datasets: [{
                    data: [{{ $sellersStatus->approved }}, {{ $sellersStatus->pending }}, {{ $sellersStatus->rejected }}],
                    backgroundColor: [
                        'rgba(39, 174, 96, 0.8)',
                        'rgba(243, 156, 18, 0.8)',
                        'rgba(231, 76, 60, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Products by Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($productsByCategory->pluck('category')) !!},
                datasets: [{
                    label: 'Jumlah Produk',
                    data: {!! json_encode($productsByCategory->pluck('total')) !!},
                    backgroundColor: 'rgba(102, 126, 234, 0.7)',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // Stores by Province Chart
        const provinceCtx = document.getElementById('provinceChart').getContext('2d');
        new Chart(provinceCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($storesByProvince->pluck('province')) !!},
                datasets: [{
                    label: 'Jumlah Toko',
                    data: {!! json_encode($storesByProvince->pluck('total')) !!},
                    backgroundColor: 'rgba(118, 75, 162, 0.7)',
                    borderColor: 'rgba(118, 75, 162, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // Reviewers by Province Chart
        const reviewersCtx = document.getElementById('reviewersChart').getContext('2d');
        new Chart(reviewersCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($reviewsByProvince->pluck('reviewer_province')) !!},
                datasets: [{
                    data: {!! json_encode($reviewsByProvince->pluck('total')) !!},
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(240, 147, 251, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(67, 233, 123, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(231, 76, 60, 0.8)',
                        'rgba(39, 174, 96, 0.8)',
                        'rgba(243, 156, 18, 0.8)',
                        'rgba(155, 89, 182, 0.8)',
                        'rgba(52, 152, 219, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
        </script>
        
        <div class="card">
            <div class="card-header">
                <h3>Quick Actions</h3>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <a href="/sellers" class="btn btn-primary">Kelola Penjual</a>
                <a href="/dashboard/platform" class="btn btn-primary">Dashboard Platform</a>
                <a href="/reports" class="btn btn-primary">Download Laporan</a>
            </div>
        </div>
    @elseif(Auth::user()->isPenjual())
        <!-- Charts untuk Penjual -->
        @php
            $productsByCategory = \App\Models\Product::where('seller_id', Auth::user()->seller_id)
                ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                ->select('product_categories.name as category', \DB::raw('COUNT(*) as total'))
                ->groupBy('product_categories.name')
                ->get();
            
            $ratingDistribution = \App\Models\Product::where('seller_id', Auth::user()->seller_id)
                ->selectRaw('
                    CASE 
                        WHEN average_rating >= 4.5 THEN "5 Bintang"
                        WHEN average_rating >= 3.5 THEN "4 Bintang"
                        WHEN average_rating >= 2.5 THEN "3 Bintang"
                        WHEN average_rating >= 1.5 THEN "2 Bintang"
                        ELSE "1 Bintang"
                    END as rating_range,
                    COUNT(*) as count
                ')
                ->groupBy('rating_range')
                ->orderByRaw('MIN(average_rating) DESC')
                ->get();
        @endphp
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="card">
                <h3 style="margin-bottom: 20px;">Produk Saya per Kategori</h3>
                <canvas id="myProductsChart" style="max-height: 250px;"></canvas>
            </div>
            
            <div class="card">
                <h3 style="margin-bottom: 20px;">Distribusi Rating</h3>
                <canvas id="myRatingsChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
        
        <script>
        // Produk per Kategori Chart
        @if($productsByCategory->count() > 0)
        const categoryCtx = document.getElementById('myProductsChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($productsByCategory->pluck('category')) !!},
                datasets: [{
                    data: {!! json_encode($productsByCategory->pluck('total')) !!},
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(240, 147, 251, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(67, 233, 123, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(231, 76, 60, 0.8)',
                        'rgba(52, 152, 219, 0.8)',
                        'rgba(155, 89, 182, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        @endif
        
        // Rating Distribution Chart
        @if($ratingDistribution->count() > 0)
        const ratingCtx = document.getElementById('myRatingsChart').getContext('2d');
        new Chart(ratingCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($ratingDistribution->pluck('rating_range')) !!},
                datasets: [{
                    label: 'Jumlah Produk',
                    data: {!! json_encode($ratingDistribution->pluck('count')) !!},
                    backgroundColor: 'rgba(67, 233, 123, 0.7)',
                    borderColor: 'rgba(67, 233, 123, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        @endif
        </script>
        
        <div class="card">
            <div class="card-header">
                <h3>Quick Actions</h3>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <a href="{{ route('seller.products.upload.form') }}" class="btn btn-primary">➕ Upload Produk Baru</a>
                <a href="/products" class="btn btn-primary">📦 Kelola Produk</a>
                <a href="/seller/dashboard" class="btn btn-primary">📊 Dashboard Lengkap</a>
                <a href="/seller/reports" class="btn btn-primary">📄 Laporan Toko</a>
            </div>
        </div>
    @else
        <!-- Charts untuk Pengunjung -->
        @php
            $popularCategories = \App\Models\Product::join('product_categories', 'products.category_id', '=', 'product_categories.id')
                ->select('product_categories.name as category', \DB::raw('COUNT(*) as total'))
                ->groupBy('product_categories.name')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();
            
            // Top Stores berdasarkan sold_count (paling banyak dibeli)
            $storePeriod = request('store_period', 'all');
            $topStoresQuery = \App\Models\Seller::select('sellers.id', 'sellers.store_name', \DB::raw('SUM(products.sold_count) as total_sold'))
                ->join('products', 'sellers.id', '=', 'products.seller_id')
                ->where('sellers.status', 'approved')
                ->groupBy('sellers.id', 'sellers.store_name');
            
            // Filter berdasarkan periode
            if ($storePeriod == 'daily') {
                $topStoresQuery->whereDate('products.created_at', today());
            } elseif ($storePeriod == 'monthly') {
                $topStoresQuery->whereMonth('products.created_at', now()->month)
                    ->whereYear('products.created_at', now()->year);
            } elseif ($storePeriod == 'yearly') {
                $topStoresQuery->whereYear('products.created_at', now()->year);
            }
            
            $topStores = $topStoresQuery->orderBy('total_sold', 'desc')
                ->limit(5)
                ->get();
        @endphp
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="card">
                <h3 style="margin-bottom: 20px;">Kategori Produk Populer</h3>
                <canvas id="categoryChart" style="max-height: 250px;"></canvas>
            </div>
            
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="margin: 0;">Toko Terpopuler</h3>
                    <select id="storePeriodFilter" onchange="window.location.href='?store_period=' + this.value" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="all" {{ request('store_period', 'all') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                        <option value="daily" {{ request('store_period') == 'daily' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="monthly" {{ request('store_period') == 'monthly' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="yearly" {{ request('store_period') == 'yearly' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                </div>
                <canvas id="topStoresChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
        
        <script>
        // Kategori Populer Chart
        @if($popularCategories->count() > 0)
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($popularCategories->pluck('category')) !!},
                datasets: [{
                    data: {!! json_encode($popularCategories->pluck('total')) !!},
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(240, 147, 251, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(67, 233, 123, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        @endif
        
        // Top Stores Chart
        @if($topStores->count() > 0)
        const topStoresCtx = document.getElementById('topStoresChart').getContext('2d');
        new Chart(topStoresCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topStores->pluck('store_name')) !!},
                datasets: [{
                    label: 'Total Terjual',
                    data: {!! json_encode($topStores->pluck('total_sold')) !!},
                    backgroundColor: 'rgba(155, 89, 182, 0.7)',
                    borderColor: 'rgba(155, 89, 182, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 100
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
        @endif
        </script>
        
        <div class="card">
            <div class="card-header">
                <h3>Quick Actions</h3>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <a href="/products" class="btn btn-primary">🛍️ Belanja Sekarang</a>
                <a href="/sellers/create" class="btn btn-primary">🏪 Daftar Jadi Penjual</a>
                <a href="/reviews" class="btn btn-primary">⭐ Tulis Review</a>
            </div>
        </div>
    @endif
@endsection

@section('extra-scripts')
<script>
const userRole = '{{ Auth::user()->role }}';
const sellerId = {{ Auth::user()->seller_id ?? 'null' }};

async function loadDashboardData() {
    try {
        // PLATFORM ADMIN
        if (userRole === 'platform') {
            const res = await fetch('/api/dashboard/summary');
            const data = await res.json();
            if (data.success) {
                document.getElementById('totalSellers').textContent = data.data.total_sellers;
                document.getElementById('totalProducts').textContent = data.data.total_products;
                document.getElementById('totalReviews').textContent = data.data.total_reviews;
                document.getElementById('avgRating').textContent = (data.data.average_rating || 0) + '/5';
            }
        }
        
        // PENJUAL
        if (userRole === 'penjual' && sellerId) {
            const res = await fetch('/api/seller/dashboard/' + sellerId);
            const data = await res.json();
            console.log('Seller data:', data);
            
            if (data.success) {
                document.getElementById('myProducts').textContent = data.data.total_products || 0;
                document.getElementById('myStock').textContent = data.data.total_stock || 0;
                document.getElementById('myReviews').textContent = data.data.total_reviews || 0;
                document.getElementById('myRating').textContent = (data.data.average_rating || 0) + '/5';
            }
        }
        
        // PENGUNJUNG
        if (userRole === 'pengunjung') {
            const res = await fetch('/api/dashboard/summary');
            const data = await res.json();
            if (data.success) {
                if (document.getElementById('totalProducts')) {
                    document.getElementById('totalProducts').textContent = data.data.total_products;
                }
                if (document.getElementById('totalSellers')) {
                    document.getElementById('totalSellers').textContent = data.data.total_sellers;
                }
                if (document.getElementById('totalReviews')) {
                    document.getElementById('totalReviews').textContent = data.data.total_reviews;
                }
                if (document.getElementById('myReviews')) {
                    document.getElementById('myReviews').textContent = '0';
                }
            }
        }
            
            // Load Charts based on role
            if (userRole === 'platform') {
                // Platform Admin Charts
                const sellersRes = await fetch('/api/dashboard/sellers-status');
                const sellersData = await sellersRes.json();
                
                if (sellersData.success && document.getElementById('sellersChart')) {
                    const data = sellersData.data;
                    const ctx = document.getElementById('sellersChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Approved', 'Pending', 'Rejected'],
                            datasets: [{
                                data: [data.approved, data.pending, data.rejected],
                                backgroundColor: [
                                    'rgba(39, 174, 96, 0.8)',
                                    'rgba(243, 156, 18, 0.8)',
                                    'rgba(231, 76, 60, 0.8)'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                            }
                        }
                    }
                });
            }
            
            // Load Category Chart (Platform & Pengunjung)
            if ((userRole === 'platform' || userRole === 'pengunjung') && document.getElementById('categoryChart')) {
                const categoryRes = await fetch('/api/dashboard/products-by-category');
                const categoryData = await categoryRes.json();
                
                if (categoryData.success) {
                    const data = categoryData.data.slice(0, 5); // Top 5
                    const ctx = document.getElementById('categoryChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.map(item => item.category),
                            datasets: [{
                                label: 'Jumlah Produk',
                                data: data.map(item => item.total),
                                backgroundColor: 'rgba(102, 126, 234, 0.7)',
                                borderColor: 'rgba(102, 126, 234, 1)',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            scales: {
                                y: {beginAtZero: true}
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }
            }
            
            // Load Province Chart (Platform only)
            if (userRole === 'platform' && document.getElementById('provinceChart')) {
                const provinceRes = await fetch('/api/dashboard/stores-by-province');
                const provinceData = await provinceRes.json();
                
                if (provinceData.success) {
                    const data = provinceData.data;
                    const ctx = document.getElementById('provinceChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.map(item => item.province),
                            datasets: [{
                                label: 'Jumlah Toko',
                                data: data.map(item => item.total),
                                backgroundColor: 'rgba(118, 75, 162, 0.7)',
                                borderColor: 'rgba(118, 75, 162, 1)',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            indexAxis: 'y',
                            scales: {
                                x: {beginAtZero: true}
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }
            }
            
            // Load Charts for Penjual
            if (userRole === 'penjual' && sellerId) {
                // Get seller dashboard data for charts
                const sellerRes = await fetch(`/api/seller/dashboard/${sellerId}`);
                const sellerData = await sellerRes.json();
                
                if (sellerData.success) {
                    // Products by category chart
                    if (document.getElementById('myProductsChart') && sellerData.data.products_by_category) {
                        const categoryData = sellerData.data.products_by_category;
                        const ctx = document.getElementById('myProductsChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: categoryData.map(item => item.category),
                                datasets: [{
                                    data: categoryData.map(item => item.total),
                                    backgroundColor: [
                                        'rgba(102, 126, 234, 0.8)',
                                        'rgba(240, 147, 251, 0.8)',
                                        'rgba(79, 172, 254, 0.8)',
                                        'rgba(67, 233, 123, 0.8)',
                                        'rgba(255, 159, 64, 0.8)'
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                    }
                    
                    // Rating distribution chart
                    if (document.getElementById('myRatingsChart') && sellerData.data.rating_distribution) {
                        const ratingData = sellerData.data.rating_distribution;
                        const ctx = document.getElementById('myRatingsChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ratingData.map(item => item.rating_range),
                                datasets: [{
                                    label: 'Jumlah Produk',
                                    data: ratingData.map(item => item.count),
                                    backgroundColor: 'rgba(67, 233, 123, 0.7)',
                                    borderColor: 'rgba(67, 233, 123, 1)',
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {beginAtZero: true}
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    }
                }
            }
            
        } catch (error) {
            console.error('Error loading dashboard:', error);
        }
    }
    
    loadDashboardData();
</script>
@endsection
