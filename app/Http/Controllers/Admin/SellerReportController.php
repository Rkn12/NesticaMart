<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SellerReportController extends Controller
{
    /**
     * Show seller status report
     */
    public function index(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'platform') {
            return redirect('/dashboard')->with('error', 'Akses ditolak');
        }
        
        $status = $request->get('status', 'all'); // all, active, inactive
        
        $query = User::with('seller')
            ->where('role', 'penjual')
            ->whereHas('seller');
            
        if ($status === 'active') {
            $query->whereHas('seller', function($q) {
                $q->where('is_active', true);
            });
        } elseif ($status === 'inactive') {
            $query->whereHas('seller', function($q) {
                $q->where('is_active', false);
            });
        }
        
        $sellers = $query->orderBy('created_at', 'desc')->get();
        
        $statistics = [
            'total' => User::where('role', 'penjual')->whereHas('seller')->count(),
            'active' => User::where('role', 'penjual')->whereHas('seller', function($q) {
                $q->where('is_active', true);
            })->count(),
            'inactive' => User::where('role', 'penjual')->whereHas('seller', function($q) {
                $q->where('is_active', false);
            })->count(),
        ];
        
        return view('admin.sellers.report', compact('sellers', 'statistics', 'status'));
    }

    /**
     * Generate PDF report
     */
    public function generatePdf(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'platform') {
            return redirect('/dashboard')->with('error', 'Akses ditolak');
        }
        
        $status = $request->get('status', 'all');
        
        $query = User::with('seller')
            ->where('role', 'penjual')
            ->whereHas('seller');
            
        if ($status === 'active') {
            $query->whereHas('seller', function($q) {
                $q->where('is_active', true);
            });
        } elseif ($status === 'inactive') {
            $query->whereHas('seller', function($q) {
                $q->where('is_active', false);
            });
        }
        
        $sellers = $query->orderBy('created_at', 'desc')->get();
        
        $statistics = [
            'total' => User::where('role', 'penjual')->whereHas('seller')->count(),
            'active' => User::where('role', 'penjual')->whereHas('seller', function($q) {
                $q->where('is_active', true);
            })->count(),
            'inactive' => User::where('role', 'penjual')->whereHas('seller', function($q) {
                $q->where('is_active', false);
            })->count(),
        ];
        
        // Generate actual PDF using DomPDF
        $pdf = Pdf::loadView('admin.sellers.report-pdf', compact('sellers', 'statistics', 'status'));
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'laporan-penjual-' . $status . '-' . date('Y-m-d-H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }
}
