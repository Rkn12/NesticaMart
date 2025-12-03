<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;
use Symfony\Component\HttpFoundation\Response;

class CheckSellerActive
{
    /**
     * Handle an incoming request.
     * Cek apakah seller masih aktif dan approved
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya cek untuk user yang sudah login
        if (Auth::check()) {
            $user = Auth::user();
            
            // Hanya cek untuk seller (bukan platform admin)
            if ($user->role === 'penjual') {
                // Gunakan relasi untuk mengambil seller data
                $seller = $user->seller;
                
                // Jika seller tidak ditemukan, logout
                if (!$seller) {
                    Auth::logout();
                    return redirect('/login')
                        ->with('error', 'Akun seller tidak ditemukan. Silakan hubungi admin.');
                }
                
                // Jika seller tidak approved, logout
                if ($seller->status !== 'approved') {
                    Auth::logout();
                    return redirect('/login')
                        ->with('error', 'Akun Anda belum disetujui atau telah ditolak. Silakan hubungi admin.');
                }
                
                // Jika seller tidak aktif, logout
                if (!$seller->is_active) {
                    Auth::logout();
                    return redirect('/login')
                        ->with('error', 'Akun Anda telah dinonaktifkan oleh admin. Silakan hubungi admin untuk informasi lebih lanjut.');
                }
            }
        }
        
        return $next($request);
    }
}
