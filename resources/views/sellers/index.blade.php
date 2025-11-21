@extends('layouts.app')

@section('title', 'Daftar Penjual')
@section('page-title', 'Kelola Penjual')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Daftar Penjual</h3>
            <a href="#" class="btn btn-primary" onclick="alert('Fitur tambah penjual via API')">+ Tambah Penjual</a>
        </div>
        
        <div class="search-bar">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari nama toko, pemilik, atau email...">
            <select id="statusFilter" class="form-control" style="max-width: 200px;">
                <option value="">Semua Status</option>
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
            </select>
            <button class="btn btn-primary" onclick="loadSellers()">Cari</button>
        </div>
        
        <div id="sellersTable">
            <div style="text-align: center; padding: 40px;">
                <p>Loading...</p>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
<script>
    async function loadSellers() {
        const search = document.getElementById('searchInput').value;
        const status = document.getElementById('statusFilter').value;
        
        let url = '/sellers';
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (status) params.append('status', status);
        if (params.toString()) url += '?' + params.toString();
        
        try {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (result.success) {
                displaySellers(result.data.data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    function displaySellers(sellers) {
        const tableHTML = `
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Toko</th>
                        <th>Pemilik</th>
                        <th>Email</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    ${sellers.map(seller => `
                        <tr>
                            <td>${seller.id}</td>
                            <td>${seller.store_name}</td>
                            <td>${seller.owner_name}</td>
                            <td>${seller.email}</td>
                            <td>${seller.city}, ${seller.province}</td>
                            <td>
                                <span class="badge badge-${seller.status === 'approved' ? 'success' : seller.status === 'pending' ? 'warning' : 'danger'}">
                                    ${seller.status}
                                </span>
                            </td>
                            <td>
                                <a href="/sellers/${seller.id}" class="btn btn-sm btn-primary">Detail</a>
                                ${seller.status === 'pending' ? `
                                    <button class="btn btn-sm btn-success" onclick="verifySeller(${seller.id}, 'approved')">Approve</button>
                                    <button class="btn btn-sm btn-danger" onclick="verifySeller(${seller.id}, 'rejected')">Reject</button>
                                ` : ''}
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
        
        document.getElementById('sellersTable').innerHTML = tableHTML;
    }
    
    async function verifySeller(id, status) {
        const note = prompt(`Catatan verifikasi (${status}):`);
        if (note === null) return;
        
        try {
            const response = await fetch(`/sellers/${id}/verify`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: status,
                    verification_note: note,
                    verified_by: '{{ Auth::user()->name }}'
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Verifikasi berhasil!');
                loadSellers();
            } else {
                alert('Gagal melakukan verifikasi');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        }
    }
    
    // Load sellers on page load
    loadSellers();
</script>
@endsection
