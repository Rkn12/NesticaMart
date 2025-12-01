<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductUploadController;
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
    return redirect('/products');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration untuk penjual
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ========================================
// PUBLIC ROUTES (Tanpa Login untuk Pengunjung)
// ========================================
// Katalog produk - bisa diakses tanpa login
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/review', [ProductController::class, 'reviewForm'])->name('products.review');

// Review - bisa submit tanpa login
Route::post('/reviews', [ProductReviewController::class, 'store']);
Route::get('/reviews', [ProductReviewController::class, 'index'])->name('reviews.index');

// ========================================
// PROTECTED ROUTES (Requires Auth)
// ========================================
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
        Route::get('/seller/dashboard', function () {
            return view('seller.dashboard');
        })->name('seller.dashboard');
        
        Route::get('/seller/reports', function () {
            return view('seller.reports');
        })->name('seller.reports');
        
        // Product Upload Routes - SRS-MartPlace-03
        Route::get('/seller/products/upload', [\App\Http\Controllers\ProductUploadController::class, 'showUploadForm'])
            ->name('seller.products.upload.form');
        Route::post('/seller/products/upload', [\App\Http\Controllers\ProductUploadController::class, 'uploadProduct'])
            ->name('seller.products.upload');
        Route::get('/seller/products', function () {
            return view('seller.products.index');
        })->name('seller.products');
    });
    
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
// PRODUCT API ROUTES (Protected - untuk penjual)
// ========================================
Route::prefix('api/products')->middleware('auth')->group(function () {
    // Get kategori produk
    Route::get('/categories', [ProductController::class, 'getCategories']);
    
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
// REVIEW API ROUTES (untuk data stats)
// ========================================
Route::prefix('api/reviews')->group(function () {
    // Get review by product
    Route::get('/product/{product_id}', [ProductReviewController::class, 'getByProduct']);
    
    // Get rating stats
    Route::get('/product/{product_id}/stats', [ProductReviewController::class, 'getRatingStats']);
    
    // Update review (protected)
    Route::put('/{id}', [ProductReviewController::class, 'update'])->middleware('auth');
    
    // Delete review (protected)
    Route::delete('/{id}', [ProductReviewController::class, 'destroy'])->middleware('auth');
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
