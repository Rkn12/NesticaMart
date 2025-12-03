<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Http\Controllers\SellerNotificationController;
use Illuminate\Http\Request;

class SellerManagementController extends Controller
{
    protected $notificationController;

    public function __construct()
    {
        $this->notificationController = new SellerNotificationController();
    }

    /**
     * SRS-MartPlace-09: Tampilkan daftar seller untuk admin platform
     */
    public function index(Request $request)
    {
        $query = Seller::query();
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan is_active
        if ($request->has('active') && $request->active !== '') {
            $query->where('is_active', $request->active == '1');
        }
        
        // Search
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('store_name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $sellers = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.sellers.index', compact('sellers'));
    }

    /**
     * SRS-MartPlace-09: Toggle status aktif/non-aktif seller
     */
    public function toggleActive(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        
        // Hanya seller yang approved yang bisa di toggle active/inactive
        if ($seller->status !== 'approved') {
            return redirect()->back()->with('error', 'Hanya seller yang sudah disetujui yang dapat diatur status aktif/non-aktif');
        }
        
        $seller->is_active = !$seller->is_active;
        $seller->save();
        
        $status = $seller->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()->with('success', "Seller {$seller->store_name} berhasil {$status}");
    }

    /**
     * Update status approval seller
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'note' => 'nullable|string|max:500'
        ]);
        
        $seller = Seller::findOrFail($id);
        $oldStatus = $seller->status;
        
        $seller->status = $request->status;
        $seller->verification_note = $request->note;
        
        // Jika approved, set active secara default
        if ($request->status === 'approved') {
            $seller->is_active = true;
        }
        
        $seller->save();
        
        // Kirim email notifikasi
        if ($request->status === 'approved' && $oldStatus !== 'approved') {
            $this->notificationController->sendApprovalNotification($seller);
        } elseif ($request->status === 'rejected') {
            $this->notificationController->sendRejectionNotification($seller, $request->note);
        }
        
        return redirect()->back()->with('success', 'Status seller berhasil diperbarui');
    }

    /**
     * Tampilkan detail seller
     */
    public function show($id)
    {
        $seller = Seller::with(['products.category'])->findOrFail($id);
        return view('admin.sellers.show', compact('seller'));
    }
}
