<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\VerificationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    /**
     * SRS-MartPlace-01: Registrasi sebagai penjual
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:150',
            'store_description' => 'nullable|string',
            'owner_name' => 'required|string|max:150',
            'nik' => 'required|string|max:20|unique:sellers,nik',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:150|unique:sellers,email',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'subdistrict' => 'required|string|max:100',
            'kelurahan' => 'required|string|max:100',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'address' => 'required|string',
            'pic_name' => 'required|string|max:150',
            'pic_phone' => 'required|string|max:20',
            'pic_email' => 'required|email|max:150',
            'foto_ktp_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_ktp_pic' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle file uploads
        $fotoKtpPath = null;
        $fileKtpPath = null;
        
        if ($request->hasFile('foto_ktp_pic')) {
            $fotoKtpPath = $request->file('foto_ktp_pic')->store('ktp_photos', 'public');
        }
        
        if ($request->hasFile('file_ktp_pic')) {
            $fileKtpPath = $request->file('file_ktp_pic')->store('ktp_files', 'public');
        }

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
            'pic_name' => $request->pic_name,
            'pic_phone' => $request->pic_phone,
            'pic_email' => $request->pic_email,
            'foto_ktp_pic' => $fotoKtpPath,
            'file_ktp_pic' => $fileKtpPath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil. Menunggu verifikasi admin.',
            'data' => $seller
        ], 201);
    }

    /**
     * SRS-MartPlace-02: Verifikasi penjual (approve/reject)
     */
    public function verify(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
            'verification_note' => 'nullable|string',
            'verified_by' => 'required|string|max:150', // admin name/email
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $seller = Seller::findOrFail($id);
        $oldStatus = $seller->status;

        // Update status verifikasi
        $seller->update([
            'status' => $request->status,
            'verification_note' => $request->verification_note,
        ]);

        // Simpan log verifikasi
        VerificationLog::create([
            'seller_id' => $seller->id,
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'notes' => $request->verification_note,
            'verified_by' => $request->verified_by,
        ]);

        // SRS-MartPlace-02: Kirim email notifikasi
        $this->sendVerificationEmail($seller, $request->status);

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi berhasil dilakukan.',
            'data' => $seller
        ]);
    }

    /**
     * Kirim email notifikasi hasil verifikasi
     */
    private function sendVerificationEmail($seller, $status)
    {
        $subject = $status === 'approved' 
            ? 'Selamat! Akun Penjual Anda Telah Disetujui' 
            : 'Informasi Verifikasi Akun Penjual';

        $message = $status === 'approved'
            ? "Selamat {$seller->owner_name}, akun penjual Anda telah disetujui. Anda dapat mulai berjualan di marketplace kami."
            : "Mohon maaf {$seller->owner_name}, akun penjual Anda tidak dapat disetujui. Alasan: {$seller->verification_note}";

        // Implementasi email menggunakan Mail facade
        Mail::raw($message, function ($mail) use ($seller, $subject) {
            $mail->to($seller->email)
                ->subject($subject);
        });
    }

    /**
     * Get daftar penjual (untuk admin)
     */
    public function index(Request $request)
    {
        $query = Seller::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by province
        if ($request->has('province')) {
            $query->where('province', $request->province);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('store_name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $sellers = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $sellers
        ]);
    }

    /**
     * Get detail penjual
     */
    public function show($id)
    {
        $seller = Seller::with(['products', 'verificationLogs'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $seller
        ]);
    }

    /**
     * Update data penjual
     */
    public function update(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'store_name' => 'sometimes|string|max:150',
            'store_description' => 'nullable|string',
            'phone' => 'sometimes|string|max:20',
            'province' => 'sometimes|string|max:100',
            'city' => 'sometimes|string|max:100',
            'subdistrict' => 'sometimes|string|max:100',
            'address' => 'sometimes|string',
            'pic_name' => 'sometimes|string|max:150',
            'pic_phone' => 'sometimes|string|max:20',
            'pic_email' => 'sometimes|email|max:150',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $seller->update($request->only([
            'store_name', 'store_description', 'phone', 
            'province', 'city', 'subdistrict', 'address',
            'pic_name', 'pic_phone', 'pic_email'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data penjual berhasil diupdate.',
            'data' => $seller
        ]);
    }
}
