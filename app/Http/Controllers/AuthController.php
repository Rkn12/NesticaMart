<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Cek khusus untuk seller
            if ($user->role === 'penjual') {
                // Gunakan relasi yang sudah dibuat
                $seller = $user->seller;
                
                if (!$seller) {
                    Auth::logout();
                    return redirect('/login')
                        ->with('error', 'Akun seller tidak ditemukan.');
                }
                
                // Cek status approved
                if ($seller->status !== 'approved') {
                    Auth::logout();
                    $message = $seller->status === 'pending' 
                        ? 'Akun Anda masih menunggu persetujuan admin.' 
                        : 'Akun Anda telah ditolak oleh admin.';
                    return redirect('/login')->with('error', $message);
                }
                
                // Cek status aktif
                if (!$seller->is_active) {
                    Auth::logout();
                    return redirect('/login')
                        ->with('error', 'Akun Anda telah dinonaktifkan oleh admin. Silakan hubungi admin untuk informasi lebih lanjut.');
                }
                
                // Redirect seller ke seller dashboard
                return redirect()->intended('/seller/dashboard');
            }
            
            // Redirect non-seller (platform admin) ke dashboard umum
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration - Registrasi Penjual
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Data Toko
            'store_name' => 'required|string|max:150',
            'store_description' => 'required|string',
            
            // Data Pemilik (PIC = Pemilik)
            'owner_name' => 'required|string|max:150',
            'nik' => 'required|string|size:16|unique:sellers,nik',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:150|unique:sellers,email',
            'foto_ktp_pic' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'file_ktp_pic' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
            
            // Alamat
            'address' => 'required|string',
            'rt' => 'required|string|size:3|regex:/^[0-9]{3}$/',
            'rw' => 'required|string|size:3|regex:/^[0-9]{3}$/',
            'kelurahan' => 'required|string|max:100',
            'subdistrict' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload files
        $fotoKtpPath = null;
        $fileKtpPath = null;
        
        if ($request->hasFile('foto_ktp_pic')) {
            $fotoKtpPath = $request->file('foto_ktp_pic')->store('ktp/foto', 'public');
        }
        
        if ($request->hasFile('file_ktp_pic')) {
            $fileKtpPath = $request->file('file_ktp_pic')->store('ktp/file', 'public');
        }

        // Create seller record with status pending
        // PIC = Pemilik (data sama)
        $seller = Seller::create([
            'store_name' => $request->store_name,
            'store_description' => $request->store_description,
            'owner_name' => $request->owner_name,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'email' => $request->email,
            'province' => $request->province,
            'city' => $request->city,
            'subdistrict' => $request->subdistrict,
            'kelurahan' => $request->kelurahan,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'address' => $request->address,
            'pic_name' => $request->owner_name, // PIC = Pemilik
            'pic_phone' => $request->phone,
            'pic_email' => $request->email,
            'foto_ktp_pic' => $fotoKtpPath,
            'file_ktp_pic' => $fileKtpPath,
            'status' => 'pending',
        ]);

        return view('auth.registration-success');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
