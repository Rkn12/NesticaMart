@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Kelola Produk Saya</h2>
        <a href="{{ route('seller.products.upload.form') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Upload Produk Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div id="products-container">
                <div class="text-center py-5">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat produk...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Load seller products
const sellerId = {{ Auth::user()->seller_id }};

fetch(`/api/seller/products/${sellerId}`)
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('products-container');
        
        if (data.success && data.data.length > 0) {
            let html = `
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            data.data.forEach(product => {
                const mainImage = product.images && product.images.length > 0 
                    ? `/storage/${product.images.find(img => img.is_main)?.image_path || product.images[0].image_path}`
                    : '/images/no-image.png';
                
                html += `
                    <tr>
                        <td>
                            <img src="${mainImage}" alt="${product.name}" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td>
                            <strong>${product.name}</strong>
                            <br><small class="text-muted">${product.merek || 'Tanpa merek'}</small>
                        </td>
                        <td>${product.category?.name || '-'}</td>
                        <td>Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</td>
                        <td>
                            <span class="badge ${product.stock > 10 ? 'bg-success' : product.stock > 0 ? 'bg-warning' : 'bg-danger'}">
                                ${product.stock} unit
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-success">Aktif</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/products/${product.id}" class="btn btn-outline-primary" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            html += `
                        </tbody>
                    </table>
                </div>
            `;
            
            container.innerHTML = html;
        } else {
            container.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada produk</h5>
                    <p class="text-muted">Mulai upload produk pertama Anda untuk menjangkau lebih banyak pembeli</p>
                    <a href="{{ route('seller.products.upload.form') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Upload Produk Pertama
                    </a>
                </div>
            `;
        }
    })
    .catch(error => {
        document.getElementById('products-container').innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h5>Terjadi kesalahan</h5>
                <p>Tidak dapat memuat data produk</p>
                <button class="btn btn-outline-primary" onclick="location.reload()">Coba Lagi</button>
            </div>
        `;
    });
</script>
@endsection