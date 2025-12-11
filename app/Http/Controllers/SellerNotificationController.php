<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Mail\SellerRejectionMail;
use App\Mail\SellerApprovalMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SellerNotificationController extends Controller
{
    /**
     * Send registration confirmation
     */
    public function sendRegistrationConfirmation(Seller $seller)
    {
        // TODO: Implement registration confirmation email
        // For now, just return success or log it
        return ['success' => true, 'message' => 'Email konfirmasi registrasi berhasil dikirim'];
    }

    /**
     * Send approval notification (After admin approval)
     * Sesuai SRS-MartPlace-02: Kirim notifikasi email hasil verifikasi
     */
    public function sendApprovalNotification(Seller $seller, ?string $credentials = null)
    {
        try {
            Mail::to($seller->email)->send(new SellerApprovalMail($seller, $credentials));
            return ['success' => true, 'message' => 'Email persetujuan berhasil dikirim'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Gagal mengirim email persetujuan: ' . $e->getMessage()];
        }
    }

    /**
     * Send rejection notification (Admin rejection)
     * Sesuai SRS-MartPlace-02: Kirim notifikasi email hasil verifikasi
     */
    public function sendRejectionNotification(Seller $seller, string $rejectionReason = '')
    {
        try {
            Mail::to($seller->email)->send(new SellerRejectionMail($seller, $rejectionReason));
            return ['success' => true, 'message' => 'Email penolakan berhasil dikirim'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Gagal mengirim email penolakan'];
        }
    }
}
