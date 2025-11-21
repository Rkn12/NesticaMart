<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * SRS-MartPlace-07: Dashboard platform dengan berbagai grafik
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'products_by_category' => $this->getProductsByCategory(),
                'stores_by_province' => $this->getStoresByProvince(),
                'sellers_status' => $this->getSellersStatus(),
                'reviewers_count' => $this->getReviewersCount(),
            ]
        ]);
    }

    /**
     * SRS-MartPlace-07: Grafik jumlah produk berdasarkan kategori
     */
    public function getProductsByCategory()
    {
        $data = DB::table('products')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select('product_categories.name as category', DB::raw('COUNT(*) as total'))
            ->groupBy('product_categories.id', 'product_categories.name')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * SRS-MartPlace-07: Grafik jumlah toko berdasarkan lokasi propinsi
     */
    public function getStoresByProvince()
    {
        $data = DB::table('sellers')
            ->select('province', DB::raw('COUNT(*) as total'))
            ->where('status', 'approved')
            ->groupBy('province')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * SRS-MartPlace-07: Grafik jumlah user penjual aktif dan tidak aktif
     */
    public function getSellersStatus()
    {
        $data = [
            'approved' => Seller::where('status', 'approved')->count(),
            'pending' => Seller::where('status', 'pending')->count(),
            'rejected' => Seller::where('status', 'rejected')->count(),
            'total' => Seller::count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * SRS-MartPlace-07: Grafik jumlah pengunjung yang memberikan komentar dan rating
     */
    public function getReviewersCount()
    {
        $totalReviewers = ProductReview::distinct('reviewer_email')->count('reviewer_email');
        $totalReviews = ProductReview::count();
        
        // Review per bulan (12 bulan terakhir)
        $reviewsPerMonth = DB::table('product_reviews')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_reviewers' => $totalReviewers,
                'total_reviews' => $totalReviews,
                'reviews_per_month' => $reviewsPerMonth,
            ]
        ]);
    }

    /**
     * Summary statistik platform
     */
    public function getSummary()
    {
        $summary = [
            'total_sellers' => Seller::count(),
            'approved_sellers' => Seller::where('status', 'approved')->count(),
            'pending_sellers' => Seller::where('status', 'pending')->count(),
            'total_products' => Product::count(),
            'total_reviews' => ProductReview::count(),
            'average_rating' => round(Product::avg('average_rating'), 2),
            'total_stock' => Product::sum('stock'),
            'low_stock_products' => Product::where('stock', '<', 2)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $summary
        ]);
    }
}
