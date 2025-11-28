<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SellerNotificationController extends Controller
{
    /**
     * Send registration confirmation email to seller (pending verification)
     */
    public function sendRegistrationConfirmation(Seller $seller)
    {
        $subject = 'Registrasi Penjual Diterima (Menunggu Verifikasi)';
        $message = "Halo {$seller->owner_name},\n\nTerima kasih telah mendaftar sebagai penjual di platform kami. Pendaftaran Anda telah diterima dan saat ini status akun Anda: PENDING. Tim kami akan memproses verifikasi dokumen Anda.\n\nSalam,\nTim Marketplace";

        Mail::raw($message, function ($mail) use ($seller, $subject) {
            $mail->to($seller->email)
                 ->subject($subject);
        });
    }

    /**
     * Send verification result email. If approved and $plainPassword provided, include credentials.
     *
     * @param Seller $seller
     * @param string $status 'approved'|'rejected'
     * @param string|null $plainPassword
     */
    public function sendVerificationResult(Seller $seller, string $status, ?string $plainPassword = null)
    {
        if ($status === 'approved') {
            $subject = 'Selamat! Akun Penjual Anda Telah Disetujui';

            $message = "Selamat {$seller->owner_name},\n\nAkun penjual Anda telah disetujui. Anda sekarang dapat login menggunakan informasi berikut:\n\nEmail: {$seller->email}\nPassword: {$plainPassword}\n\nSilakan ubah password Anda setelah login untuk keamanan.\n\nSalam,\nTim Marketplace";

            Mail::raw($message, function ($mail) use ($seller, $subject) {
                $mail->to($seller->email)
                    ->subject($subject);
            });
        } else {
            $subject = 'Informasi Verifikasi Akun Penjual';
            $message = "Mohon maaf {$seller->owner_name}, akun penjual Anda tidak dapat disetujui. Alasan: {$seller->verification_note}\n\nJika Anda ingin mengajukan kembali, silakan perbaiki dokumen yang diperlukan dan hubungi tim kami.";

            Mail::raw($message, function ($mail) use ($seller, $subject) {
                $mail->to($seller->email)
                    ->subject($subject);
            });
        }
    }
}
