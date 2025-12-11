@extends('layouts.app')

@section('title', 'My Products - Nestica')

@section('content')
<!-- Success Notification -->
@if(session('success'))
<div id="success-notification" style="position: fixed; top: 20px; right: 20px; background: #7E991E; color: white; padding: 16px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999; display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 500; opacity: 1; transition: opacity 0.3s ease;">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 6L9 17l-5-5"/>
    </svg>
    {{ session('success') }}
</div>
<script>
    setTimeout(() => {
        const notification = document.getElementById('success-notification');
        if (notification) {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }
    }, 3000);
</script>
@endif

<style>
    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .products-header h1 {
        font-size: 28px;
        color: #483A2E;
        font-weight: bold;
    }
    
    .btn-add-product {
        background: #483A2E;
        color: white;
        padding: 12px 28px;
        border: none;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    
    .btn-add-product:hover {
        background: #362C23;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(72, 58, 46, 0.3);
    }
    
    .product-info-section {
        background: rgba(213, 205, 194, 0.2);
        padding: 30px;
        border-radius: 15px;
        box-shadow: none;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .section-header h3 {
        font-size: 20px;
        color: #483A2E;
        font-weight: bold;
    }

    .columns-row {
        display: flex;
        gap: 95px;
        padding-left: 310px;
        margin-bottom: 15px;
        padding-right: 10px;
    }
    
    .column-header {
        font-weight: bold;
        color: #7E991E;
        font-size: 12px;
        text-align: center;
        border: 2px solid #7E991E;
        border-radius: 15px;
        padding: 5px 15px;
    }
    
    .product-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .product-item {
        display: flex;
        align-items: center;
        padding: 15px 15px 25px 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .product-item:last-child {
        border-bottom: none;
    }
    
    .product-image-wrapper {
        width: 80px;
        height: 80px;
        margin-right: 20px;
        flex-shrink: 0;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }
    
    .product-name {
        flex: 0 0 150px;
        margin-right: 20px;
    }
    
    .product-name h4 {
        font-size: 15px;
        font-weight: 600;
        color: #483A2E;
        margin-bottom: 3px;
    }
    
    .product-name p {
        font-size: 16px;
        color: #999;
    }

    .product-info-grid {
        display: flex;
        gap: 8px;
        align-items: center;
        flex: 1;
        margin-left: -10px;
    }
    
    .info-item {
        text-align: center;
        flex: 0 0 150px;
    }
    
    .info-item.delete-column {
        flex: 0 0 140px;
        text-align: right;
        padding-right: 0;
    }
    
    .info-value {
        font-size: 15px;
        font-weight: normal;
        color: #483A2E;
    }
    
    .rating-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }
    
    .rating-display {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .stars {
        display: flex;
        gap: 2px;
    }
    
    .star {
        color: #EFCD77;
        font-size: 14px;
    }
    
    .star.empty {
        color: #D5CDC2;
    }
    
    .rating-number {
        font-size: 15px;
        font-weight: normal;
        color: #483A2E;
    }
    
    .review-text {
        font-size: 11px;
        color: #999;
    }
    
    .btn-delete {
        background: #483A2E;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }
    
    .btn-delete:hover {
        background: #362C23;
        transform: scale(1.05);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }
    
    .empty-state h3 {
        font-size: 20px;
        color: #483A2E;
        margin-bottom: 10px;
    }
    
    .empty-state p {
        font-size: 14px;
        margin-bottom: 20px;
    }
</style>

<div class="products-header">
    <h1>Products</h1>
    <a href="{{ route('seller.products.upload.form') }}" class="btn-add-product">
        <span>+</span> Add Your Products
    </a>
</div>

<div class="product-info-section">
    <div class="section-header">
        <h3>Product List</h3>
    </div>
    
    <div class="columns-row">
        <span class="column-header">Price</span>
        <span class="column-header">Stock</span>
        <span class="column-header">Rating</span>
    </div>
    
    <div class="product-list" id="productList">
        <div style="text-align: center; padding: 40px; color: #666;">Loading products...</div>
    </div>
</div>

<script>
// Load products
function loadProducts() {
    const sellerId = {{ Auth::user()->seller ? Auth::user()->seller->id : 0 }};
    
    fetch(`/api/seller/${sellerId}/all-products`)
        .then(response => response.json())
        .then(data => {
            const productList = document.getElementById('productList');
            
            if (data.products && data.products.length > 0) {
                productList.innerHTML = data.products.map(product => {
                    const rating = parseFloat(product.average_rating) || 0;
                    const fullStars = Math.floor(rating);
                    const emptyStars = 5 - fullStars;
                    
                    let starsHtml = '';
                    for (let i = 0; i < fullStars; i++) starsHtml += '<span class="star">★</span>';
                    for (let i = 0; i < emptyStars; i++) starsHtml += '<span class="star empty">★</span>';
                    
                    const reviewText = product.review_count === 1 ? 'review' : 'reviews';
                    const imageUrl = product.image_url 
                        ? `/storage/${product.image_url}` 
                        : 'https://via.placeholder.com/80x80/D5CDC2/483A2E?text=No+Image';
                    
                    return `
                        <div class="product-item">
                            <div class="product-image-wrapper">
                                <img src="${imageUrl}" alt="${product.name}" class="product-image">
                            </div>
                            <div class="product-name">
                                <h4>${product.name}</h4>
                                <p>${product.category}</p>
                            </div>
                            <div class="product-info-grid">
                                <div class="info-item">
                                    <div class="info-value">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-value">${product.stock}</div>
                                </div>
                                <div class="info-item">
                                    <div class="rating-container">
                                        <div class="rating-display">
                                            <div class="stars">${starsHtml}</div>
                                            <span class="rating-number">${rating.toFixed(1)}</span>
                                        </div>
                                        <div class="review-text">Based on ${product.review_count} ${reviewText}</div>
                                    </div>
                                </div>
                                <div class="info-item delete-column">
                                    <button class="btn-delete" onclick="deleteProduct(${product.id}, '${product.name.replace(/'/g, "\\'")}')">
                                        Delete Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            } else {
                productList.innerHTML = `
                    <div class="empty-state">
                        <h3>No Products Yet</h3>
                        <p>Start adding products to your store</p>
                        <a href="{{ route('seller.products.upload.form') }}" class="btn-add-product">
                            <span>+</span> Add Your First Product
                        </a>
                    </div>`;
            }
        })
        .catch(() => {
            document.getElementById('productList').innerHTML =
                `<div style="text-align:center;padding:40px;color:#e74c3c;">
                    Error loading products. Please refresh the page.
                 </div>`;
        });
}

function deleteProduct(id, name) {
    if (confirm(`Delete "${name}"?`)) {
        fetch(`/api/seller/products/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => loadProducts());
    }
}

loadProducts();
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