@extends('layouts.app')

@section('title', 'Laporan Penjual')
@section('page-title', 'Laporan Daftar Akun Penjual')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>📊 Laporan Status Penjual</h3>
        <div style="display: flex; gap: 15px; align-items: center;">
            <!-- Filter Status -->
            <form method="GET" action="{{ route('admin.sellers.report') }}" style="display: flex; gap: 10px; align-items: center;">
                <select name="status" class="form-control" style="width: auto;" onchange="this.form.submit()">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif Saja</option>
                    <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Tidak Aktif Saja</option>
                </select>
            </form>
            
            <!-- Download PDF Button -->
            <a href="{{ route('admin.sellers.report.pdf') }}?status={{ $status }}" 
               class="btn btn-primary" target="_blank">
                📄 Download PDF
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0;">
        <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;">
            <h3 style="margin: 0; font-size: 2em;">{{ $statistics['total'] }}</h3>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Total Penjual</p>
        </div>
        
        <div class="stat-card" style="background: linear-gradient(135deg, #007bff 0%, #6f42c1 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;">
            <h3 style="margin: 0; font-size: 2em;">{{ $statistics['active'] }}</h3>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Aktif</p>
        </div>
        
        <div class="stat-card" style="background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;">
            <h3 style="margin: 0; font-size: 2em;">{{ $statistics['inactive'] }}</h3>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Tidak Aktif</p>
        </div>
    </div>

    <!-- Table -->
    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Penjual</th>
                    <th>Email Login</th>
                    <th>Nama Toko</th>
                    <th>Email Toko</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sellers as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->seller->store_name }}</td>
                    <td>{{ $user->seller->email }}</td>
                    <td>{{ $user->seller->city }}, {{ $user->seller->province }}</td>
                    <td>
                        @if($user->seller->is_active)
                            <span class="badge" style="background: #28a745; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                                ✅ Aktif
                            </span>
                        @else
                            <span class="badge" style="background: #dc3545; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                                ❌ Tidak Aktif
                            </span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #666; padding: 40px;">
                        📭 Tidak ada data penjual untuk status: <strong>{{ ucfirst($status) }}</strong>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.form-control {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: white;
}

.btn {
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
    display: inline-block;
    text-align: center;
    transition: all 0.3s;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #6f42c1 100%);
    color: white;
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,123,255,0.3);
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #333;
}

.table tr:hover {
    background: #f8f9fa;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.card-header h3 {
    margin: 0;
    color: #333;
}
</style>
@endsection