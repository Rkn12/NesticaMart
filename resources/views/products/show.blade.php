@extends('layouts.app')

@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')

@section('content')
    <div class="card">
        <a href="/products" class="btn btn-sm btn-primary" style="width: fit-content; margin-bottom: 20px;">← Kembali</a>
        
        <div id="productDetail">
            <div style="text-align: center; padding: 40px;">
                <p>Loading...</p>
            </div>
        </div>
    </div>
    
    <div class="card">
        <h3 style="margin-bottom: 20px;">Tambah Review</h3>
        <form id="reviewForm" onsubmit="submitReview(event)">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" id="reviewerName" class="form-control" required>
            </div>
            <div class="form-group">
                <label>No. HP</label>
                <input type="text" id="reviewerPhone" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="reviewerEmail" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Rating (1-5)</label>
                <select id="rating" class="form-control" required>
                    <option value="5">5 - Sangat Baik</option>
                    <option value="4">4 - Baik</option>
                    <option value="3">3 - Cukup</option>
                    <option value="2">2 - Kurang</option>
                    <option value="1">1 - Buruk</option>
                </select>
            </div>
            <div class="form-group">
                <label>Komentar</label>
                <textarea id="comment" class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Review</button>
        </form>
    </div>
    
    <div class="card">
        <h3 style="margin-bottom: 20px;">Review Produk</h3>
        <div id="reviewsList">
            <p>Loading reviews...</p>
        </div>
    </div>
@endsection

@section('extra-scripts')
<script>
    const productId = {{ $id }};
    
    async function loadProductDetail() {
        try {
            const response = await fetch(`/products/${productId}`, {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();
            
            if (result.success) {
                displayProductDetail(result.data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    function displayProductDetail(product) {
        const detailHTML = `
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
                <div>
                    <div style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 120px;">
                        📦
                    </div>
                </div>
                <div>
                    <h2 style="margin-bottom: 10px;">${product.name}</h2>
                    <p style="color: #667eea; font-size: 32px; font-weight: bold; margin-bottom: 20px;">
                        Rp ${product.price.toLocaleString('id-ID')}
                    </p>
                    
                    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                        <span class="badge badge-${product.condition === 'new' ? 'success' : 'warning'}">
                            ${product.condition === 'new' ? 'Baru' : 'Bekas'}
                        </span>
                        <span style="color: #f39c12;">⭐ ${product.average_rating || 0}/5</span>
                        <span>Stok: ${product.stock}</span>
                    </div>
                    
                    <h4 style="margin-top: 20px; margin-bottom: 10px;">Deskripsi</h4>
                    <p style="line-height: 1.6; color: #555;">${product.description}</p>
                    
                    <h4 style="margin-top: 20px; margin-bottom: 10px;">Informasi Produk</h4>
                    <table style="width: 100%;">
                        <tr><td><strong>Kategori:</strong></td><td>${product.category?.name || '-'}</td></tr>
                        <tr><td><strong>Berat:</strong></td><td>${product.weight || '-'} gram</td></tr>
                        <tr><td><strong>Kondisi:</strong></td><td>${product.condition === 'new' ? 'Baru' : 'Bekas'}</td></tr>
                        <tr><td><strong>Lokasi:</strong></td><td>${product.location_city}, ${product.location_province}</td></tr>
                    </table>
                    
                    <h4 style="margin-top: 20px; margin-bottom: 10px;">Penjual</h4>
                    <p><strong>${product.seller?.store_name || 'Unknown'}</strong></p>
                    <p style="color: #999; font-size: 14px;">${product.seller?.city || ''}, ${product.seller?.province || ''}</p>
                </div>
            </div>
        `;
        
        document.getElementById('productDetail').innerHTML = detailHTML;
    }
    
    async function loadReviews() {
        try {
            const response = await fetch(`/reviews/product/${productId}`, {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();
            
            if (result.success) {
                displayReviews(result.data.data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    function displayReviews(reviews) {
        if (reviews.length === 0) {
            document.getElementById('reviewsList').innerHTML = '<p>Belum ada review</p>';
            return;
        }
        
        const reviewsHTML = reviews.map(review => `
            <div style="border-bottom: 1px solid #eee; padding: 15px 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <strong>${review.reviewer_name}</strong>
                    <span style="color: #f39c12;">${'⭐'.repeat(review.rating)}</span>
                </div>
                <p style="color: #555; margin-bottom: 5px;">${review.comment || 'Tidak ada komentar'}</p>
                <p style="color: #999; font-size: 12px;">${new Date(review.created_at).toLocaleDateString('id-ID')}</p>
            </div>
        `).join('');
        
        document.getElementById('reviewsList').innerHTML = reviewsHTML;
    }
    
    async function submitReview(event) {
        event.preventDefault();
        
        const data = {
            product_id: productId,
            reviewer_name: document.getElementById('reviewerName').value,
            reviewer_phone: document.getElementById('reviewerPhone').value,
            reviewer_email: document.getElementById('reviewerEmail').value,
            rating: parseInt(document.getElementById('rating').value),
            comment: document.getElementById('comment').value
        };
        
        try {
            const response = await fetch('/reviews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Review berhasil ditambahkan!');
                document.getElementById('reviewForm').reset();
                loadReviews();
                loadProductDetail(); // Refresh rating
            } else {
                alert('Gagal menambahkan review');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        }
    }
    
    loadProductDetail();
    loadReviews();
</script>
@endsection
