<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerReportController;
use Illuminate\Support\Facades\Route;

// ========================================
// AUTH ROUTES
// ========================================
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    });
    
    // Platform Admin Only Routes
    Route::middleware('role:platform')->group(function () {
        Route::get('/sellers', function (\Illuminate\Http\Request $request) {
            $query = \App\Models\Seller::query();
            
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('store_name', 'like', "%{$search}%")
                      ->orWhere('owner_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            
            $sellers = $query->orderBy('created_at', 'desc')->paginate(10);
            
            return view('sellers.index', compact('sellers'));
        })->name('sellers.index');
        
        Route::get('/sellers/{id}', function ($id) {
            $seller = \App\Models\Seller::with(['products.category'])->findOrFail($id);
            return view('sellers.show', compact('seller'));
        })->name('sellers.show');
        
        Route::get('/dashboard/platform', function () {
            return view('dashboard.platform');
        });
        
        Route::get('/reports', function () {
            return view('reports.index');
        });
    });
    
    // Penjual Only Routes
    Route::middleware('role:penjual')->group(function () {
        Route::get('/products/create', function () {
            return view('products.create');
        })->name('products.create');
        
        Route::get('/seller/dashboard', function () {
            return view('seller.dashboard');
        })->name('seller.dashboard');
        
        Route::get('/seller/reports', function () {
            return view('seller.reports');
        })->name('seller.reports');
    });
    
    // Public Routes (Pengunjung + Penjual can access)
    Route::get('/sellers/create', function () {
        return view('sellers.create');
    })->name('sellers.create');
    
    Route::get('/reviews', [ProductReviewController::class, 'index'])->name('reviews.index');
});

// ========================================
// SELLER API ROUTES (SRS-01, SRS-02)
// ========================================
Route::prefix('api/sellers')->group(function () {
    // Registrasi penjual
    Route::post('/register', [SellerController::class, 'register']);
    
    // Get daftar penjual (admin) - API
    Route::get('/', [SellerController::class, 'index']);
    
    // Get detail penjual - API
    Route::get('/{id}', [SellerController::class, 'show']);
    
    // Update data penjual
    Route::put('/{id}', [SellerController::class, 'update']);
    
    // Verifikasi penjual (admin)
    Route::post('/{id}/verify', [SellerController::class, 'verify']);
});

// ========================================
// PRODUCT ROUTES (SRS-03, SRS-04, SRS-05)
// ========================================
Route::prefix('products')->group(function () {
    // Get katalog produk dengan pencarian
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    
    // Get kategori produk
    Route::get('/categories', [ProductController::class, 'getCategories']);
    
    // Get detail produk
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
    
    // Halaman tulis review
    Route::get('/{id}/review', [ProductController::class, 'reviewForm'])->name('products.review');
    
    // Upload/create produk (penjual)
    Route::post('/', [ProductController::class, 'store']);
    
    // Update produk
    Route::put('/{id}', [ProductController::class, 'update']);
    
    // Delete produk
    Route::delete('/{id}', [ProductController::class, 'destroy']);
    
    // Get produk by seller
    Route::get('/seller/{seller_id}', [ProductController::class, 'getBySellerDashboard']);
});

// ========================================
// PRODUCT REVIEW ROUTES (SRS-06)
// ========================================
Route::prefix('reviews')->group(function () {
    // Tambah review & rating
    Route::post('/', [ProductReviewController::class, 'store']);
    
    // Get review by product
    Route::get('/product/{product_id}', [ProductReviewController::class, 'getByProduct']);
    
    // Get rating stats
    Route::get('/product/{product_id}/stats', [ProductReviewController::class, 'getRatingStats']);
    
    // Update review
    Route::put('/{id}', [ProductReviewController::class, 'update']);
    
    // Delete review
    Route::delete('/{id}', [ProductReviewController::class, 'destroy']);
});

// ========================================
// PLATFORM DASHBOARD API ROUTES (SRS-07)
// ========================================
Route::prefix('api/dashboard')->group(function () {
    // Dashboard API
    Route::get('/', [DashboardController::class, 'index']);
    
    // Summary statistik
    Route::get('/summary', [DashboardController::class, 'getSummary']);
    
    // Grafik produk per kategori
    Route::get('/products-by-category', [DashboardController::class, 'getProductsByCategory']);
    
    // Grafik toko per propinsi
    Route::get('/stores-by-province', [DashboardController::class, 'getStoresByProvince']);
    
    // Grafik status penjual
    Route::get('/sellers-status', [DashboardController::class, 'getSellersStatus']);
    
    // Grafik reviewers
    Route::get('/reviewers-count', [DashboardController::class, 'getReviewersCount']);
});

// ========================================
// SELLER DASHBOARD API ROUTES (SRS-08)
// ========================================
Route::prefix('api/seller/dashboard')->group(function () {
    // Dashboard penjual
    Route::get('/{seller_id}', [SellerDashboardController::class, 'index']);
});

Route::prefix('seller-dashboard/{seller_id}')->group(function () {
    // Dashboard penjual
    Route::get('/', [SellerDashboardController::class, 'index']);
    
    // Summary statistik penjual
    Route::get('/summary', [SellerDashboardController::class, 'getSummary']);
    
    // Grafik stok per produk
    Route::get('/stock-per-product', [SellerDashboardController::class, 'getStockPerProduct']);
    
    // Grafik rating per produk
    Route::get('/rating-per-product', [SellerDashboardController::class, 'getRatingPerProduct']);
    
    // Grafik reviewers by province
    Route::get('/reviewers-by-province', [SellerDashboardController::class, 'getReviewersByProvince']);
    
    // Riwayat perubahan stok
    Route::get('/stock-history', [SellerDashboardController::class, 'getStockHistory']);
});

// ========================================
// PLATFORM REPORT ROUTES (SRS-09, SRS-10, SRS-11)
// ========================================
Route::prefix('reports')->group(function () {
    // Laporan status penjual (PDF)
    Route::get('/seller-status', [ReportController::class, 'sellerStatusReport']);
    
    // Laporan penjual per propinsi (PDF)
    Route::get('/seller-by-province', [ReportController::class, 'sellerByProvinceReport']);
    
    // Laporan produk & rating (PDF)
    Route::get('/product-rating', [ReportController::class, 'productRatingReport']);
    
    // Get list provinces
    Route::get('/provinces', [ReportController::class, 'getProvinces']);
    
    // Preview (JSON)
    Route::get('/preview/seller-status', [ReportController::class, 'previewSellerStatus']);
});

// ========================================
// SELLER REPORT ROUTES (SRS-12, SRS-13, SRS-14)
// ========================================
Route::prefix('seller-reports/{seller_id}')->group(function () {
    // Laporan stock produk (PDF)
    Route::get('/stock', [SellerReportController::class, 'stockReport']);
    
    // Laporan stock by rating (PDF)
    Route::get('/stock-by-rating', [SellerReportController::class, 'stockByRatingReport']);
    
    // Laporan stock barang segera habis (PDF)
    Route::get('/low-stock', [SellerReportController::class, 'lowStockReport']);
    
    // Preview (JSON)
    Route::get('/preview/stock', [SellerReportController::class, 'previewStock']);
    Route::get('/preview/low-stock', [SellerReportController::class, 'previewLowStock']);
});
