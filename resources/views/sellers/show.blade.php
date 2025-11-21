@extends('layouts.app')

@section('title', 'Detail Penjual')
@section('page-title', 'Detail Penjual')

@section('content')
    <div class="card">
        <a href="/sellers" class="btn btn-sm btn-primary" style="width: fit-content; margin-bottom: 20px;">← Kembali</a>
        
        <div id="sellerDetail">
            <div style="text-align: center; padding: 40px;">
                <p>Loading...</p>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
<script>
    async function loadSellerDetail() {
        const id = {{ $id }};
        
        try {
            const response = await fetch(`/sellers/${id}`, {
                headers: {
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (result.success) {
                displaySellerDetail(result.data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    function displaySellerDetail(seller) {
        const detailHTML = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <h3 style="margin-bottom: 20px;">Informasi Toko</h3>
                    <table style="width: 100%;">
                        <tr><td><strong>Nama Toko:</strong></td><td>${seller.store_name}</td></tr>
                        <tr><td><strong>Deskripsi:</strong></td><td>${seller.store_description || '-'}</td></tr>
                        <tr><td><strong>Status:</strong></td><td>
                            <span class="badge badge-${seller.status === 'approved' ? 'success' : seller.status === 'pending' ? 'warning' : 'danger'}">
                                ${seller.status}
                            </span>
                        </td></tr>
                        <tr><td><strong>Catatan Verifikasi:</strong></td><td>${seller.verification_note || '-'}</td></tr>
                    </table>
                    
                    <h3 style="margin: 30px 0 20px;">Informasi Pemilik</h3>
                    <table style="width: 100%;">
                        <tr><td><strong>Nama:</strong></td><td>${seller.owner_name}</td></tr>
                        <tr><td><strong>NIK:</strong></td><td>${seller.nik}</td></tr>
                        <tr><td><strong>Email:</strong></td><td>${seller.email}</td></tr>
                        <tr><td><strong>Telepon:</strong></td><td>${seller.phone}</td></tr>
                    </table>
                </div>
                
                <div>
                    <h3 style="margin-bottom: 20px;">Alamat</h3>
                    <table style="width: 100%;">
                        <tr><td><strong>Provinsi:</strong></td><td>${seller.province}</td></tr>
                        <tr><td><strong>Kota:</strong></td><td>${seller.city}</td></tr>
                        <tr><td><strong>Kecamatan:</strong></td><td>${seller.subdistrict}</td></tr>
                        <tr><td><strong>Alamat:</strong></td><td>${seller.address}</td></tr>
                    </table>
                    
                    <h3 style="margin: 30px 0 20px;">PIC (Person In Charge)</h3>
                    <table style="width: 100%;">
                        <tr><td><strong>Nama:</strong></td><td>${seller.pic_name}</td></tr>
                        <tr><td><strong>Email:</strong></td><td>${seller.pic_email}</td></tr>
                        <tr><td><strong>Telepon:</strong></td><td>${seller.pic_phone}</td></tr>
                    </table>
                </div>
            </div>
            
            <div style="margin-top: 30px;">
                <h3 style="margin-bottom: 20px;">Produk (${seller.products?.length || 0})</h3>
                ${seller.products && seller.products.length > 0 ? `
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${seller.products.map(product => `
                                <tr>
                                    <td>${product.id}</td>
                                    <td>${product.name}</td>
                                    <td>Rp ${product.price.toLocaleString('id-ID')}</td>
                                    <td>${product.stock}</td>
                                    <td>⭐ ${product.average_rating || 0}/5</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                ` : '<p>Belum ada produk</p>'}
            </div>
        `;
        
        document.getElementById('sellerDetail').innerHTML = detailHTML;
    }
    
    loadSellerDetail();
</script>
@endsection
