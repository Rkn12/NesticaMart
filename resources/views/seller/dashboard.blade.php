@extends('layouts.app')

@section('content')
<style>
    .dashboard-header {
        background: #FBFDF0;
        padding: 30px;
        border-radius: 0;
        margin-bottom: 30px;
        box-shadow: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .header-left {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
    }
    
    .logo-nestica {
        font-size: 48px;
    }
    
    .welcome-text h1 {
        font-size: 32px;
        color: #483A2E;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    .welcome-text h1 .store-name {
        color: #7E991E;
        font-weight: bold;
    }
    
    .welcome-text p {
        font-size: 14px;
        color: #666;
    }
    
    .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .seller-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
    }
    
    .seller-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .seller-info h3 {
        font-size: 16px;
        color: #483A2E;
        margin-bottom: 3px;
        font-weight: bold;
    }
    
    .seller-info .status {
        font-size: 12px;
        color: #7E991E;
        font-weight: normal;
    }
    
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        padding: 40px 30px;
        border-radius: 15px;
        text-align: center;
        color: #483A2E;
    }
    
    .stat-card.green {
        background: linear-gradient(135deg, #7E991E 0%, #9CB526 100%);
    }
    
    .stat-card.pink {
        background: linear-gradient(135deg, #EFCD77 0%, #F4D98A 100%);
    }
    
    .stat-card.blue {
        background: linear-gradient(135deg, #D5CDC2 0%, #E0DAD3 100%);
    }
    
    .stat-card h2 {
        font-size: 48px;
        margin-bottom: 10px;
        font-weight: bold;
    }
    
    .stat-card p {
        font-size: 16px;
        opacity: 0.95;
    }
    
    .product-info-section {
        background: #FBFDF0;
        padding: 30px;
        border-radius: 0;
        box-shadow: none;
        margin-bottom: 30px;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #D5CDC2;
    }
    
    .section-header h3 {
        font-size: 18px;
        color: #483A2E;
        font-weight: bold;
    }
    
    .column-header {
        background: #FBFDF0;
        padding: 8px 15px;
        border-radius: 15px;
        border: 2px solid #7E991E;
        font-size: 12px;
        color: #7E991E;
        font-weight: bold;
        display: inline-block;
    }
    
    .columns-row {
        display: flex;
        justify-content: flex-start;
        gap: 100px;
        margin-bottom: 20px;
        padding-left: 390px;
    }
    
    .view-all-link {
        color: #483A2E;
        text-decoration: none;
        font-weight: normal;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
    }
    
    .view-all-link:hover {
        color: #7E991E;
    }
    
    .product-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .product-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .product-item:last-child {
        border-bottom: none;
    }
    
    .product-image-wrapper {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 5px;
    }
    
    .product-info-grid {
        display: grid;
        grid-template-columns: 285px 190px 140px 1fr;
        align-items: center;
        width: 90%;
        padding-left: 15px;
    }
    
    .product-details h4 {
        font-size: 14px;
        color: #483A2E;
        margin-bottom: 3px;
        font-weight: bold;
    }
    
    .product-details p {
        font-size: 12px;
        color: #999;
    }
    
    .product-price {
        font-size: 14px;
        color: #483A2E;
    }
    
    .product-stock {
        font-size: 14px;
        color: #483A2E;
    }
    
    .rating-display {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    
    .rating-stars {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .stars {
        color: #EFCD77;
        font-size: 16px;
    }
    
    .rating-value {
        font-size: 14px;
        color: #483A2E;
        font-weight: bold;
    }
    
    .rating-count {
        font-size: 11px;
        color: #999;
    }
    
    .rating-section {
        background: #FBFDF0;
        padding: 30px;
        border-radius: 0;
        box-shadow: none;
    }
    
    .rating-section h3 {
        font-size: 18px;
        color: #483A2E;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    .rating-subtitle {
        font-size: 12px;
        color: #7E991E;
        margin-bottom: 30px;
    }
    
    .chart-container {
        background: rgba(213, 205, 194, 0.2);
        padding: 30px;
        padding-bottom: 60px;
        border-radius: 10px;
        max-width: 900px;
        display: flex;
        gap: 15px;
    }
    
    .y-axis {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 300px;
        padding-right: 10px;
        padding-top: 0px;
        border-right: 2px solid #7E991E;
        font-size: 12px;
        color: #483A2E;
        font-weight: 500;
        min-width: 30px;
    }
    
    .y-axis span {
        position: relative;
        text-align: right;
        line-height: 0;
    }
    
    .chart-content {
        flex: 1;
        position: relative;
    }
    
    .grid-lines {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        pointer-events: none;
    }
    
    .grid-line {
        border-bottom: 1px solid #7E991E;
        opacity: 0.3;
    }
    
    .bar-chart {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 300px;
        gap: 20px;
        position: relative;
    }
    
    .bar-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        height: 100%;
        justify-content: flex-end;
        position: relative;
    }
    
    .bar {
        width: 100%;
        background: #483A2E;
        border-radius: 5px 5px 0 0;
        transition: all 0.3s;
        position: relative;
    }
    
    .bar:hover {
        background: #7E991E;
    }
    
    .bar-label {
        margin-top: 10px;
        font-size: 12px;
        color: #483A2E;
        text-align: center;
        font-weight: 500;
        position: absolute;
        bottom: -35px;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
    }
</style>

<div class="container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="header-left">
            <div class="logo-nestica"><img src="{{ asset('images/nestica-logo.png') }}" alt="Nestica" style="width: 100px; height: 100px; margin-top: 15px;" onerror="this.style.display='none'; this.parentElement.innerHTML='🪴';"></div>
            <div class="welcome-text">
                <h1>Hello, <span class="store-name" id="storeName">{{ Auth::user()->seller ? Auth::user()->seller->store_name : 'Store' }}</span></h1>
                <p>Welcome back to your dashboard.</p>
            </div>
        </div>
    </div>
    
    <!-- Statistics Bar -->
    <div class="stats-bar">
        <div class="stat-card green">
            <h2 id="totalProducts">0</h2>
            <p>Total Products</p>
        </div>
        <div class="stat-card blue">
            <h2 id="totalReviews">0</h2>
            <p>Reviews Received</p>
        </div>
        <div class="stat-card pink">
            <h2 id="avgRating">0.0</h2>
            <p>Store Rating</p>
        </div>
    </div>
    
    <!-- Product Info Section -->
    <div class="product-info-section">
        <div class="section-header">
            <h3>Product Info</h3>
            <a href="{{ route('seller.products') }}" class="view-all-link">
                →
            </a>
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
    
    <!-- Rating Distribution Section -->
    <div class="rating-section">
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <div>
                <h3 style="margin: 0;">Rating Distribution</h3>
                <p class="rating-subtitle" style="margin: 5px 0 0 0;">Based on province location</p>
            </div>
            <a href="/reviews" class="view-all-link">→</a>
        </div>
        
        <div class="chart-container">
            <div class="y-axis">
                <span>6</span>
                <span>5</span>
                <span>4</span>
                <span>3</span>
                <span>2</span>
                <span>1</span>
                <span>0</span>
            </div>
            <div class="chart-content">
                <div class="grid-lines">
                    <div class="grid-line"></div>
                    <div class="grid-line"></div>
                    <div class="grid-line"></div>
                    <div class="grid-line"></div>
                    <div class="grid-line"></div>
                    <div class="grid-line"></div>
                    <div class="grid-line"></div>
                </div>
                <div class="bar-chart" id="ratingChart">
                    <!-- Bars will be generated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Load seller dashboard data
@if(Auth::user()->seller_id)
const sellerId = {{ Auth::user()->seller_id }};
@else
console.error('Seller ID not found for user');
const sellerId = null;
@endif

if (!sellerId) {
    document.getElementById('productList').innerHTML = '<div style="text-align: center; padding: 40px; color: #e74c3c;">Error: Seller ID not found. Please contact support.</div>';
} else {
    console.log('Loading data for seller ID:', sellerId);

    // Load dashboard statistics
    fetch(`/api/seller/dashboard/${sellerId}`)
        .then(res => res.json())
        .then(data => {
            console.log('Dashboard data:', data);
            if (data.success) {
                document.getElementById('totalProducts').textContent = data.data.total_products;
                document.getElementById('totalReviews').textContent = data.data.total_reviews || 0;
                document.getElementById('avgRating').textContent = parseFloat(data.data.average_rating || 0).toFixed(1);
            }
        })
        .catch(error => {
            console.error('Error loading dashboard stats:', error);
        });

    // Load top 3 products
    fetch(`/api/seller/${sellerId}/products?limit=3`)
        .then(res => res.json())
        .then(data => {
            console.log('Products data:', data);
            const container = document.getElementById('productList');
            if (data.success && data.data.length > 0) {
                container.innerHTML = '';
                data.data.forEach(product => {
                    const imageUrl = 'https://via.placeholder.com/80x80/D5CDC2/483A2E?text=No+Image';
                    
                    const rating = parseFloat(product.average_rating) || 0;
                    const reviewCount = parseInt(product.review_count) || 0;
                    const stars = '★'.repeat(Math.floor(rating)) + '☆'.repeat(5 - Math.floor(rating));
                    
                    container.innerHTML += `
                        <div class="product-item">
                            <div class="product-image-wrapper">
                                <img src="https://via.placeholder.com/80x80/D5CDC2/483A2E?text=No+Image" alt="${product.name}" class="product-image">
                            </div>
                            <div class="product-info-grid">
                                <div class="product-details">
                                    <h4>${product.name}</h4>
                                    <p>${product.category ? product.category.name : 'Uncategorized'}</p>
                                </div>
                                <div class="product-price">Rp. ${parseInt(product.price).toLocaleString('id-ID')}</div>
                                <div class="product-stock">${product.stock}</div>
                                <div class="rating-display">
                                    <div class="rating-stars">
                                        <span class="stars">${stars}</span>
                                        <span class="rating-value">${rating.toFixed(1)}</span>
                                    </div>
                                    <span class="rating-count">Based on ${reviewCount} reviews</span>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                container.innerHTML = '<div style="text-align: center; padding: 40px; color: #666;">No products found. Start by uploading your first product!</div>';
            }
        })
        .catch(error => {
            console.error('Error loading products:', error);
            document.getElementById('productList').innerHTML = '<div style="text-align: center; padding: 40px; color: #e74c3c;">Error loading products. Please check console for details.</div>';
        });
    
    // Load rating distribution by province from API
    fetch(`/api/seller/${sellerId}/rating-distribution`)
        .then(res => res.json())
        .then(data => {
            console.log('Rating distribution:', data);
            const chartContainer = document.getElementById('ratingChart');
            
            if (data.success && data.data.length > 0) {
                const maxScale = 6; // Fixed scale 0-6
                
                data.data.forEach(item => {
                    const percentage = (item.count / maxScale) * 100;
                    const clampedPercentage = Math.min(percentage, 100);
                    
                    chartContainer.innerHTML += `
                        <div class="bar-item">
                            <div class="bar" style="height: ${clampedPercentage}%;" title="${item.count} reviews"></div>
                            <div class="bar-label">${item.province}</div>
                        </div>
                    `;
                });
            } else {
                chartContainer.innerHTML = '<div style="text-align: center; padding: 40px; color: #666;">No rating data available yet</div>';
            }
        })
        .catch(error => {
            console.error('Error loading rating distribution:', error);
            document.getElementById('ratingChart').innerHTML = '<div style="text-align: center; padding: 40px; color: #e74c3c;">Error loading chart data</div>';
        });
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

@section('extra-scripts')
@endsection
