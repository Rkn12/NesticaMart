@extends('layouts.app')

@section('title', 'Daftar Penjual')
@section('page-title', 'Kelola Penjual')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Daftar Penjual</h3>
        </div>
        
        <form method="GET" action="{{ route('sellers.index') }}" class="search-bar">
            <input type="text" name="search" class="form-control" placeholder="Cari nama toko, pemilik, atau email..." value="{{ request('search') }}">
            <select name="status" class="form-control" style="max-width: 200px;">
                <option value="">Semua Status</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
        
        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Toko</th>
                        <th>Pemilik</th>
                        <th>Email</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sellers as $seller)
                        <tr>
                            <td>{{ $seller->id }}</td>
                            <td><strong>{{ $seller->store_name }}</strong></td>
                            <td>{{ $seller->owner_name }}</td>
                            <td>{{ $seller->email }}</td>
                            <td>{{ $seller->city }}, {{ $seller->province }}</td>
                            <td>
                                @if($seller->status == 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @elseif($seller->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $seller->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('sellers.show', $seller->id) }}" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: #999;">
                                Tidak ada data penjual
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($sellers->hasPages())
            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 10px;">
                @if ($sellers->onFirstPage())
                    <span style="padding: 10px 15px; background: #e0e0e0; color: #999; border-radius: 8px; cursor: not-allowed;">‹ Prev</span>
                @else
                    <a href="{{ $sellers->previousPageUrl() }}" style="padding: 10px 15px; background: white; color: #667eea; border: 2px solid #667eea; border-radius: 8px; text-decoration: none; font-weight: 500;">‹ Prev</a>
                @endif

                @foreach(range(1, $sellers->lastPage()) as $page)
                    @if($page == $sellers->currentPage())
                        <span style="padding: 10px 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; font-weight: 500;">{{ $page }}</span>
                    @else
                        <a href="{{ $sellers->url($page) }}" style="padding: 10px 15px; background: white; color: #667eea; border: 2px solid #e0e0e0; border-radius: 8px; text-decoration: none; font-weight: 500;">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($sellers->hasMorePages())
                    <a href="{{ $sellers->nextPageUrl() }}" style="padding: 10px 15px; background: white; color: #667eea; border: 2px solid #667eea; border-radius: 8px; text-decoration: none; font-weight: 500;">Next ›</a>
                @else
                    <span style="padding: 10px 15px; background: #e0e0e0; color: #999; border-radius: 8px; cursor: not-allowed;">Next ›</span>
                @endif
            </div>
        @endif
    </div>
@endsection
