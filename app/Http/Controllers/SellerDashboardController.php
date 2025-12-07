<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerDashboardController extends Controller
{
    /**
     * SRS-MartPlace-08: Dashboard penjual dengan berbagai grafik
     */
    public function index($seller_id)
    {
        // Get summary statistics
        $totalProducts = Product::where('seller_id', $seller_id)->count();
        $totalStock = Product::where('seller_id', $seller_id)->sum('stock');
        $avgRating = Product::where('seller_id', $seller_id)->avg('average_rating');
        
        $totalReviews = ProductReview::whereHas('product', function($q) use ($seller_id) {
            $q->where('seller_id', $seller_id);
        })->count();
        
        // Get products by category
        $productsByCategory = Product::where('seller_id', $seller_id)
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select('product_categories.name as category', DB::raw('COUNT(*) as total'))
            ->groupBy('product_categories.name')
            ->get();
        
        // Get rating distribution
        $ratingDistribution = Product::where('seller_id', $seller_id)
            ->select(
                DB::raw('CASE 
                    WHEN average_rating >= 4.5 THEN "5 Stars"
                    WHEN average_rating >= 3.5 THEN "4 Stars"
                    WHEN average_rating >= 2.5 THEN "3 Stars"
                    WHEN average_rating >= 1.5 THEN "2 Stars"
                    ELSE "1 Star"
                END as rating_range'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('rating_range')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'total_products' => $totalProducts,
                'total_stock' => $totalStock,
                'total_reviews' => $totalReviews,
                'average_rating' => round($avgRating ?? 0, 1),
                'products_by_category' => $productsByCategory,
                'rating_distribution' => $ratingDistribution,
            ]
        ]);
    }

    /**
     * SRS-MartPlace-08: Grafik jumlah stok setiap produk yang dimiliki penjual
     */
    public function getStockPerProduct($seller_id)
    {
        $data = Product::where('seller_id', $seller_id)
            ->select('id', 'name', 'stock', 'average_rating')
            ->orderBy('stock', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * SRS-MartPlace-08: Grafik sebaran nilai rating per produk
     */
    public function getRatingPerProduct($seller_id)
    {
        $data = Product::where('seller_id', $seller_id)
            ->withCount('reviews')
            ->select('id', 'name', 'average_rating')
            ->orderBy('average_rating', 'desc')
            ->get()
            ->map(function($product) {
                return [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'average_rating' => $product->average_rating,
                    'total_reviews' => $product->reviews_count,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * SRS-MartPlace-08: Grafik sebaran pemberi rating berdasarkan Lokasi propinsi
     * (Menggunakan lokasi dari email/profil reviewer - asumsi dari data reviewer)
     */
    public function getReviewersByProvince($seller_id)
    {
        // Ambil semua review dari produk seller ini
        $data = DB::table('product_reviews')
            ->join('products', 'product_reviews.product_id', '=', 'products.id')
            ->where('products.seller_id', $seller_id)
            ->select(
                'product_reviews.reviewer_email',
                'product_reviews.reviewer_name',
                DB::raw('COUNT(*) as total_reviews')
            )
            ->groupBy('product_reviews.reviewer_email', 'product_reviews.reviewer_name')
            ->get();

        // Note: Untuk distribusi berdasarkan propinsi, perlu data lokasi reviewer
        // Saat ini hanya menghitung jumlah reviewer unik
        $totalReviewers = $data->count();
        $totalReviews = $data->sum('total_reviews');

        return response()->json([
            'success' => true,
            'data' => [
                'total_reviewers' => $totalReviewers,
                'total_reviews' => $totalReviews,
                'top_reviewers' => $data->sortByDesc('total_reviews')->take(10)->values(),
            ]
        ]);
    }

    /**
     * Summary statistik untuk seller
     */
    public function getSummary($seller_id)
    {
        $products = Product::where('seller_id', $seller_id)->get();
        $totalReviews = ProductReview::whereIn('product_id', $products->pluck('id'))->count();

        $summary = [
            'total_products' => $products->count(),
            'total_stock' => $products->sum('stock'),
            'average_rating' => round($products->avg('average_rating'), 2),
            'total_reviews' => $totalReviews,
            'low_stock_products' => $products->where('stock', '<', 2)->count(),
            'out_of_stock_products' => $products->where('stock', 0)->count(),
            'best_rated_product' => $products->sortByDesc('average_rating')->first(),
            'most_reviewed_product' => $products->sortByDesc(function($product) {
                return $product->reviews()->count();
            })->first(),
        ];

        return response()->json([
            'success' => true,
            'data' => $summary
        ]);
    }

    /**
     * Get riwayat perubahan stok
     */
    public function getStockHistory($seller_id, Request $request)
    {
        $query = DB::table('stock_logs')
            ->join('products', 'stock_logs.product_id', '=', 'products.id')
            ->where('products.seller_id', $seller_id)
            ->select('stock_logs.*', 'products.name as product_name')
            ->orderBy('stock_logs.created_at', 'desc');

        if ($request->has('product_id')) {
            $query->where('stock_logs.product_id', $request->product_id);
        }

        $logs = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }

    /**
     * Get products for seller
     */
    public function getProducts($seller_id, Request $request)
    {
        $limit = $request->get('limit', 10);
        
        $products = Product::where('seller_id', $seller_id)
            ->with(['category', 'images'])
            ->withCount('reviews')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'average_rating' => $product->average_rating ?? 0,
                    'review_count' => $product->reviews_count,
                    'category' => $product->category ? ['id' => $product->category->id, 'name' => $product->category->name] : null,
                    'images' => $product->images->map(function($image) {
                        return ['image_url' => $image->image_url];
                    }),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Get rating distribution by province
     */
    public function getRatingDistribution($seller_id)
    {
        try {
            $distribution = ProductReview::whereHas('product', function($q) use ($seller_id) {
                    $q->where('seller_id', $seller_id);
                })
                ->select(
                    'reviewer_province as province',
                    DB::raw('COUNT(*) as count')
                )
                ->whereNotNull('reviewer_province')
                ->where('reviewer_province', '!=', '')
                ->groupBy('reviewer_province')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $distribution
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all products for seller
     */
    public function getAllProducts($seller_id)
    {
        try {
            $products = Product::where('seller_id', $seller_id)
                ->with(['category', 'images'])
                ->withCount('reviews')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'average_rating' => $product->average_rating ?? 0,
                        'review_count' => $product->reviews_count,
                        'is_active' => $product->is_active ?? 1,
                        'category' => $product->category ? $product->category->name : 'Uncategorized',
                        'image_url' => $product->images->first() ? $product->images->first()->image_url : null,
                    ];
                });

            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle product active status
     */
    public function toggleProductStatus(Request $request, $product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            $product->is_active = $request->is_active;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete product
     */
    public function deleteProduct($product_id)
    {
        try {
            $product = Product::findOrFail($product_id);
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
