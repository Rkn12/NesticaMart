<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SellerReportController extends Controller
{
    /**
     * SRS-MartPlace-12: Laporan daftar stock produk (berdasarkan stock menurun, PDF)
     */
    public function stockReport($seller_id)
    {
        $products = Product::with(['category', 'reviews'])
            ->where('seller_id', $seller_id)
            ->orderBy('stock', 'desc')
            ->get();

        $data = [
            'title' => 'Laporan Daftar Stock Produk',
            'date' => now()->format('d F Y'),
            'time' => now()->format('H:i'),
            'processedBy' => Auth::user()->name ?? 'Admin',
            'seller' => $products->first()?->seller,
            'products' => $products,
            'summary' => [
                'total_products' => $products->count(),
                'total_stock' => $products->sum('stock'),
                'average_stock' => round($products->avg('stock'), 2),
                'low_stock_count' => $products->where('stock', '<', 2)->count(),
            ]
        ];

        $pdf = Pdf::loadView('reports.seller-stock', $data);
        return $pdf->download('laporan-stock-produk-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * SRS-MartPlace-13: Laporan daftar stock produk (berdasarkan rating menurun, PDF)
     */
    public function stockByRatingReport($seller_id)
    {
        $products = Product::with(['category', 'reviews'])
            ->where('seller_id', $seller_id)
            ->orderBy('average_rating', 'desc')
            ->get();

        $data = [
            'title' => 'Laporan Stock Produk Segera Pesan',
            'date' => now()->format('d F Y'),
            'time' => now()->format('H:i'),
            'processedBy' => Auth::user()->name ?? 'Admin',
            'seller' => $products->first()?->seller,
            'products' => $products,
            'summary' => [
                'total_products' => $products->count(),
                'total_stock' => $products->sum('stock'),
                'average_rating' => round($products->where('average_rating', '>', 0)->avg('average_rating'), 2),
                'total_reviews' => $products->sum(fn($p) => $p->reviews->count()),
            ]
        ];

        $pdf = Pdf::loadView('reports.seller-stock-by-rating', $data);
        return $pdf->download('laporan-stock-by-rating-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * SRS-MartPlace-14: Laporan daftar stock barang yang harus segera di pesan (stock < 2, PDF)
     */
    public function lowStockReport($seller_id)
    {
        $products = Product::with(['category', 'reviews'])
            ->where('seller_id', $seller_id)
            ->where('stock', '<', 2)
            ->orderBy('stock', 'asc')
            ->get();

        $data = [
            'title' => 'Laporan Stock Barang Segera Habis (Stock < 2)',
            'date' => now()->format('d F Y'),
            'time' => now()->format('H:i'),
            'processedBy' => Auth::user()->name ?? 'Admin',
            'seller' => $products->first()?->seller ?? Product::where('seller_id', $seller_id)->first()?->seller,
            'products' => $products,
            'summary' => [
                'total_products' => $products->count(),
                'out_of_stock' => $products->where('stock', 0)->count(),
                'critical_stock' => $products->where('stock', 1)->count(),
                'total_stock' => $products->sum('stock'),
            ]
        ];

        $pdf = Pdf::loadView('reports.seller-low-stock', $data);
        return $pdf->download('laporan-stock-segera-habis-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Preview laporan stock (JSON untuk testing)
     */
    public function previewStock($seller_id)
    {
        $products = Product::with(['category'])
            ->where('seller_id', $seller_id)
            ->orderBy('stock', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products,
                'summary' => [
                    'total_products' => $products->count(),
                    'total_stock' => $products->sum('stock'),
                    'average_stock' => round($products->avg('stock'), 2),
                    'low_stock_count' => $products->where('stock', '<', 2)->count(),
                ]
            ]
        ]);
    }

    /**
     * Preview laporan low stock (JSON untuk testing)
     */
    public function previewLowStock($seller_id)
    {
        $products = Product::with(['category'])
            ->where('seller_id', $seller_id)
            ->where('stock', '<', 2)
            ->orderBy('stock', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products,
                'summary' => [
                    'total_products' => $products->count(),
                    'out_of_stock' => $products->where('stock', 0)->count(),
                    'critical_stock' => $products->where('stock', 1)->count(),
                ]
            ]
        ]);
    }
}
