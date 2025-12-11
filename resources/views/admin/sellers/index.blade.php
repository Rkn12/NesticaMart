@extends('layouts.app')

@section('title', 'Kelola Penjual')
@section('page-title', 'Kelola Penjual')

@section('content')
<div class="page-header">
    <h1>Manage Sellers</h1>
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-number">{{ $sellers->total() }}</div>
            <div class="stat-label">Total Seller</div>
        </div>
        @php
            $pending = \App\Models\Seller::where('status', 'pending')->count();
            $active = \App\Models\Seller::where('status', 'approved')->where('is_active', true)->count();
        @endphp
        <div class="stat-card warning">
            <div class="stat-number">{{ $pending }}</div>
            <div class="stat-label">Pending Approval</div>
        </div>
        <div class="stat-card success">
            <div class="stat-number">{{ $active }}</div>
            <div class="stat-label">Active Sellers</div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert success">
        <span class="alert-icon">✅</span>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert error">
        <span class="alert-icon">❌</span>
        {{ session('error') }}
    </div>
@endif

{{-- Filter & Search card removed as requested --}}

<div class="card">
    <div class="card-header">
        <h3>Seller List</h3>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Store</th>
                    <th>Owner</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sellers as $seller)
                <tr class="seller-row">
                    <td>
                        <div class="seller-info">
                            <strong>{{ $seller->store_name }}</strong>
                            <small>{{ Str::limit($seller->store_description, 40) }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="owner-info">
                            <strong>{{ $seller->owner_name }}</strong>
                            <small>NIK: {{ $seller->nik }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="contact-info">
                            <div>{{ $seller->email }}</div>
                            <div>{{ $seller->phone }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="location-info">
                            {{ $seller->city }}<br>
                            <small>{{ $seller->province }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="status-badges">
                            @if($seller->status === 'approved')
                                <span class="badge badge-success">Approved</span>
                            @elseif($seller->status === 'rejected')
                                <span class="badge badge-error">Rejected</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                            
                            @if($seller->status === 'approved')
                                <br>
                                @if($seller->is_active)
                                    <span class="badge badge-active">Active</span>
                                @else
                                    <span class="badge badge-inactive">Inactive</span>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="date-info">
                            {{ $seller->created_at->format('d/m/Y') }}
                            <small>{{ $seller->created_at->diffForHumans() }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.sellers.show', $seller->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                👁️
                            </a>
                            
                            @if($seller->status === 'pending')
                                <button onclick="updateStatus({{ $seller->id }}, 'approved')" class="btn btn-success btn-sm" title="Setujui">
                                    ✅
                                </button>
                                <button onclick="updateStatus({{ $seller->id }}, 'rejected')" class="btn btn-error btn-sm" title="Tolak">
                                    ❌
                                </button>
                            @elseif($seller->status === 'approved')
                                <form method="POST" action="{{ route('admin.sellers.toggle-active', $seller->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" 
                                            class="btn {{ $seller->is_active ? 'btn-error' : 'btn-success' }} btn-sm"
                                            title="{{ $seller->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                            onclick="return confirm('Yakin ingin {{ $seller->is_active ? 'menonaktifkan' : 'mengaktifkan' }} seller ini?')">
                                        {{ $seller->is_active ? 'Nonaktif' : 'Aktif' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <div class="empty-icon">🏪</div>
                        <h3>Tidak ada seller ditemukan</h3>
                        <p>Coba ubah filter pencarian Anda</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($sellers->hasPages())
    <div class="pagination-container">
        {{ $sellers->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Modal for Status Update -->
<div id="statusModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="statusModalTitle">Update Status Seller</h3>
            <span class="modal-close">&times;</span>
        </div>
        <form id="statusForm" method="POST">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="status" id="statusValue">
                
                <div class="form-group">
                    <label for="note">💭 Catatan (opsional)</label>
                    <textarea id="note" name="note" class="form-control" rows="3" 
                              placeholder="Berikan catatan alasan approval/rejection..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal-close">Batal</button>
                <button type="submit" class="btn btn-primary" id="statusSubmit">Update Status</button>
            </div>
        </form>
    </div>
</div>

<style>
.seller-row:hover {
    background-color: #f8f9fa;
}

.seller-info strong {
    color: #2c5aa0;
    font-size: 14px;
}

.seller-info small {
    display: block;
    color: #666;
    font-size: 12px;
}

.owner-info strong {
    color: #333;
}

.owner-info small {
    display: block;
    color: #888;
    font-size: 11px;
}

.contact-info div {
    font-size: 12px;
    margin: 2px 0;
}

.location-info {
    font-size: 13px;
}

.location-info small {
    color: #666;
}

.status-badges {
    text-align: center;
}

.badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: bold;
    margin: 2px 0;
}

.badge-success { background: #d4edda; color: #155724; }
.badge-error { background: #f8d7da; color: #721c24; }
.badge-warning { background: #fff3cd; color: #856404; }
.badge-active { background: #d1ecf1; color: #0c5460; }
.badge-inactive { background: #f1f1f1; color: #6c757d; }

.date-info {
    font-size: 13px;
}

.date-info small {
    display: block;
    color: #888;
    font-size: 11px;
}

.action-buttons {
    display: flex;
    gap: 4px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 12px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
}

.btn-info { background: #17a2b8; color: white; }
.btn-success { background: #28a745; color: white; }
.btn-error { background: #dc3545; color: white; }
.btn-warning { background: #ffc107; color: #212529; }

.btn-sm:hover {
    opacity: 0.8;
    transform: translateY(-1px);
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 0;
    border-radius: 8px;
    width: 400px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.modal-header {
    padding: 16px 20px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-close {
    font-size: 24px;
    cursor: pointer;
    color: #999;
}

.modal-close:hover {
    color: #000;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 16px 20px;
    border-top: 1px solid #ddd;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.card-actions {
    display: flex;
    gap: 10px;
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}
</style>

<script>
function updateStatus(sellerId, status) {
    const modal = document.getElementById('statusModal');
    const form = document.getElementById('statusForm');
    const title = document.getElementById('statusModalTitle');
    const submitBtn = document.getElementById('statusSubmit');
    
    form.action = `/admin/sellers/${sellerId}/status`;
    document.getElementById('statusValue').value = status;
    
    if (status === 'approved') {
        title.textContent = '✅ Setujui Seller';
        submitBtn.textContent = '✅ Setujui';
        submitBtn.className = 'btn btn-success';
    } else {
        title.textContent = '❌ Tolak Seller';
        submitBtn.textContent = '❌ Tolak';
        submitBtn.className = 'btn btn-error';
    }
    
    modal.style.display = 'block';
}

// Close modal handlers
document.querySelectorAll('.modal-close').forEach(element => {
    element.onclick = function() {
        document.getElementById('statusModal').style.display = 'none';
    }
});

window.onclick = function(event) {
    const modal = document.getElementById('statusModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>

<!-- Footer -->
<div style="margin-left: -30px; margin-right: -30px; margin-bottom: -30px; margin-top: 60px;">
    <footer style="background-color: #4A3B32; color: #FDFBF0; padding: 40px 60px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div class="footer-left">
            <p style="font-size: 14px; line-height: 1.5;">
                <strong>Nestica</strong><br>
                (+62) 123 144 567<br>
                info@nestica.com
            </p>
        </div>
        <div class="footer-right" style="text-align: right; font-size: 14px;">
            <p>
                &copy; 2025 Nestica<br>
                Made with love by kelompok 4
            </p>
        </div>
    </footer>
</div>
@endsection