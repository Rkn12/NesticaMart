<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * SRS-MartPlace-09: Laporan daftar akun penjual aktif dan tidak aktif (PDF)
     */
    public function sellerStatusReport(Request $request)
    {
        $statusFilter = $request->get('status', 'all'); // all, active, inactive

        if ($statusFilter === 'active') {

            // Hanya seller yang benar-benar aktif
            $sellers = Seller::select('*')
                ->where('status', 'approved')
                ->where('is_active', true)
                ->selectRaw("(CASE WHEN status = 'approved' AND is_active = 1 THEN 1 ELSE 0 END) AS active_flag")
                ->orderByDesc('active_flag')
                ->orderBy('store_name')
                ->get();

            $title = 'Laporan Daftar Akun Penjual Aktif';

        } elseif ($statusFilter === 'inactive') {

            // Semua seller tidak aktif
            $sellers = Seller::select('*')
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('status', 'approved')->where('is_active', false);
                    })
                    ->orWhere('status', 'pending')
                    ->orWhere('status', 'rejected');
                })
                ->selectRaw("(CASE WHEN status = 'approved' AND is_active = 1 THEN 1 ELSE 0 END) AS active_flag")
                ->orderByDesc('active_flag') // ini tetap nol semua → aman
                ->orderBy('store_name')
                ->get();

            $title = 'Laporan Daftar Akun Penjual Tidak Aktif';

        } else {

            // SEMUA SELLER, disortir: aktif dulu → tidak aktif
            $sellers = Seller::select('*')
                ->selectRaw("(CASE WHEN status = 'approved' AND is_active = 1 THEN 1 ELSE 0 END) AS active_flag")
                ->orderByDesc('active_flag')
                ->orderBy('store_name')
                ->get();

            $title = 'Laporan Daftar Akun Penjual (Semua Status)';
        }

        $data = [
            'title' => $title,
            'date' => now()->format('d F Y'),
            'time' => now()->format('H:i'),
            'processedBy' => Auth::user()->name ?? 'Admin',
            'sellers' => $sellers,
            'status_filter' => $statusFilter,
        ];

        $pdf = Pdf::loadView('reports.seller-status', $data);
        return $pdf->download('laporan-status-penjual-' . now()->format('Y-m-d') . '.pdf');
    }


    /**
     * SRS-MartPlace-10: Laporan daftar penjual (toko) untuk setiap Lokasi propinsi (PDF)
     */
    public function sellerByProvinceReport(Request $request)
    {
        $province = $request->get('province');
        
        // Get all sellers regardless of is_active, just need to be approved
        $query = Seller::query();
        
        if ($province) {
            $query->where('province', $province);
            $title = "Laporan Daftar Penjual - Propinsi {$province}";
        } else {
            $title = "Laporan Daftar Penjual Semua Propinsi";
        }

        $sellers = $query->orderBy('province')->orderBy('city')->get();
        
        // Group by province
        $sellersByProvince = $sellers->groupBy('province');

        $data = [
            'title' => $title,
            'date' => now()->format('d F Y'),
            'time' => now()->format('H:i'),
            'processedBy' => Auth::user()->name ?? 'Admin',
            'sellers_by_province' => $sellersByProvince,
            'summary' => [
                'total_sellers' => $sellers->count(),
                'total_provinces' => $sellersByProvince->count(),
            ]
        ];

        $pdf = Pdf::loadView('reports.seller-by-province', $data);
        return $pdf->download('laporan-penjual-per-propinsi-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * SRS-MartPlace-11: Laporan daftar produk dan ratingnya (berdasarkan rating menurun, PDF)
     */
    public function productRatingReport(Request $request)
    {
        $query = Product::with(['seller', 'category'])
            ->withCount('reviews')
            ->orderBy('average_rating', 'desc');

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by province
        if ($request->has('province')) {
            $query->where('location_province', $request->province);
        }

        $products = $query->get();

        $data = [
            'title' => 'Laporan Daftar Produk dan Rating',
            'date' => now()->format('d F Y'),
            'time' => now()->format('H:i'),
            'processedBy' => Auth::user()->name ?? 'Admin',
            'products' => $products,
            'summary' => [
                'total_products' => $products->count(),
                'average_rating' => round($products->where('average_rating', '>', 0)->avg('average_rating'), 2),
                'total_reviews' => $products->sum('reviews_count'),
            ]
        ];

        $pdf = Pdf::loadView('reports.product-rating', $data);
        return $pdf->download('laporan-produk-rating-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Get list provinces untuk filter
     */
    public function getProvinces()
    {
        $provinces = Seller::select('province')
            ->distinct()
            ->orderBy('province')
            ->pluck('province');

        return response()->json([
            'success' => true,
            'data' => $provinces
        ]);
    }

    /**
     * Get all sellers for dropdown (API)
     */
    public function getAllSellers()
    {
        $sellers = Seller::where('status', 'approved')
            ->orderBy('store_name')
            ->get(['id', 'store_name', 'city', 'province']);

        return response()->json([
            'success' => true,
            'data' => $sellers
        ]);
    }

    /**
     * Preview laporan (JSON format untuk testing)
     */
    public function previewSellerStatus()
    {
        $activeSellers = Seller::where('status', 'approved')->get();
        $inactiveSellers = Seller::whereIn('status', ['pending', 'rejected'])->get();

        return response()->json([
            'success' => true,
            'data' => [
                'active_sellers' => $activeSellers,
                'inactive_sellers' => $inactiveSellers,
                'summary' => [
                    'total_active' => $activeSellers->count(),
                    'total_inactive' => $inactiveSellers->count(),
                ]
            ]
        ]);
    }
}
