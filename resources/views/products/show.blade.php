<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Nestica</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #FDFBF0;
            color: #4A3B32;
            padding-top: 28px;
        }

        /* Top Bar */
        .top-bar {
            background-color: #7E991E;
            color: #483A2E;
            text-align: center;
            padding: 5px;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        /* Header */
        header {
            background-color: #FDFBF0;
            padding: 20px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #4A3B32;
        }

        .logo i {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .logo span {
            font-weight: 800;
            font-size: 14px;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #4A3B32;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            border-bottom: 2px solid transparent;
        }

        .nav-links a.active {
            border-bottom: 2px solid #4A3B32;
        }

        /* Search Bar */
        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #FDFBF0;
        }

        .search-input-group {
            position: relative;
        }

        .search-input-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 12px;
        }

        .search-input {
            padding: 8px 10px 8px 30px;
            border: 1px solid #ddd;
            background-color: #E8E8E0;
            border-radius: 4px;
            font-size: 12px;
            width: 140px;
            outline: none;
        }

        .category-select {
            border: none;
            background: transparent;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            outline: none;
        }

        .btn-search {
            background-color: #4A3B32;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
        }

        .user-icon {
            font-size: 20px;
            color: #4A3B32;
            cursor: pointer;
        }

        /* Select2 Overrides for Search Bar */
        .select2-container--default .select2-selection--single {
            background-color: #E8E8E0;
            border: 1px solid #ddd;
            border-radius: 4px;
            height: 34px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
            font-size: 12px;
            color: #666;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 32px;
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 60px;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background: #4A3B32;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .back-button:hover {
            opacity: 0.9;
        }

        .product-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .product-image {
            width: 100%;
            height: 400px;
            background: #D8D0C5;
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 120px;
        }

        .product-details h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #4A3B32;
        }

        .product-price {
            font-size: 28px;
            font-weight: 800;
            color: #8B9D3B;
            margin-bottom: 20px;
        }

        .product-meta {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .badge {
            padding: 6px 12px;
            background: #8B9D3B;
            color: #fff;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .rating-display {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .stars {
            color: #E5E5E5;
        }

        .stars .filled {
            color: #F4D03F;
        }

        .product-info {
            margin-top: 30px;
        }

        .product-info h3 {
            font-size: 16px;
            font-weight: 700;
            margin-top: 20px;
            margin-bottom: 15px;
            color: #4A3B32;
        }

        .product-info p {
            line-height: 1.6;
            color: #555;
            margin-bottom: 10px;
        }

        .product-info table {
            width: 100%;
            line-height: 2;
        }

        .product-info table tr td {
            padding: 5px 0;
            color: #666;
        }

        /* Reviews Section */
        .reviews-section {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 2px solid #eee;
        }

        .reviews-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .reviews-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: #4A3B32;
        }

        .btn-write-review {
            padding: 12px 24px;
            background: #4A3B32;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-write-review:hover {
            opacity: 0.9;
        }

        .review-item {
            border-bottom: 1px solid #eee;
            padding: 20px 0;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .reviewer-name {
            font-weight: 700;
            color: #333;
            font-size: 16px;
        }

        .review-rating {
            font-size: 14px;
            color: #F4D03F;
        }

        .review-comment {
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .review-meta {
            color: #999;
            font-size: 13px;
            display: flex;
            gap: 15px;
        }

        .no-reviews {
            text-align: center;
            color: #999;
            padding: 40px 0;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background-color: #FDFBF0;
            margin: auto;
            padding: 30px;
            border-radius: 0;
            width: 90%;
            max-width: 600px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-height: 90vh;
            overflow-y: auto;
            animation: slideIn 0.3s;
        }

        @keyframes slideIn {
            from { transform: translate(-50%, -60%); opacity: 0; }
            to { transform: translate(-50%, -50%); opacity: 1; }
        }

        .close-btn {
            color: #4A3B32;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            background: none;
        }

        .close-btn:hover {
            opacity: 0.7;
        }

        .modal h2 {
            font-size: 24px;
            font-weight: 800;
            color: #4A3B32;
            margin-bottom: 20px;
            clear: both;
        }

        .star-rating {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 32px;
        }

        .star-rating i {
            cursor: pointer;
            color: #E5E5E5;
            transition: color 0.2s;
        }

        .star-rating i:hover,
        .star-rating i.selected {
            color: #F4D03F;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4A3B32;
        }

        .form-group label .required {
            color: red;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #4A3B32;
        }

        .form-group-select {
            width: 100% !important;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #8B9D3B;
        }

        .form-hint {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }

        .modal-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-submit {
            flex: 1;
            padding: 12px;
            background: #4A3B32;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }

        .btn-cancel {
            flex: 1;
            padding: 12px;
            background: #E8E8E0;
            color: #4A3B32;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-cancel:hover {
            opacity: 0.9;
        }

        /* Success Modal */
        .success-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .success-content {
            background-color: #FDFBF0;
            margin: auto;
            padding: 40px;
            border-radius: 0;
            width: 90%;
            max-width: 400px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .success-icon {
            font-size: 60px;
            color: #27ae60;
            margin-bottom: 20px;
        }

        .success-content h3 {
            font-size: 24px;
            font-weight: 800;
            color: #4A3B32;
            margin-bottom: 15px;
        }

        .success-content p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .success-content button {
            padding: 12px 30px;
            background: #4A3B32;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }

        .success-content button:hover {
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background-color: #4A3B32;
            color: #FDFBF0;
            padding: 40px 60px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 60px;
        }

        .footer-left p {
            font-size: 14px;
            line-height: 1.5;
        }

        .footer-right {
            text-align: right;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="top-bar">
        BRINGS WARMTH AND CHARACTER INTO EVERY CORNER OF YOUR HOME.
    </div>

    <header>
        <div class="header-left">
            <a href="/" class="logo">
                <i class="fas fa-couch"></i>
                <span>Nestica</span>
            </a>
            
        </div>

        <form action="{{ route('products.index') }}" method="GET" class="search-container">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="search-input" placeholder="Search Product" value="{{ request('search') }}">
            </div>
            
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" name="store_name" class="search-input" placeholder="Store Name" value="{{ request('store_name') }}">
            </div>

            <div style="position: relative;">
                <select name="category_id" class="category-select">
                    <option value="">Kategori</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <select name="province" id="province" class="search-input select2" style="width: 140px;">
                    <option value="">Province</option>
                </select>
            </div>
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <select name="city" id="city" class="search-input select2" style="width: 140px;" disabled>
                    <option value="">City</option>
                </select>
            </div>


            <button type="submit" class="btn-search">Search</button>
        </form>

        <div class="user-actions">
            @if(Auth::check())
                <a href="{{ url('/dashboard') }}" class="user-icon" title="Dashboard">
                    <i class="fas fa-user"></i>
                </a>
            @else
                <a href="{{ url('/login') }}" class="user-icon" title="Login">
                    <i class="fas fa-user"></i>
                </a>
            @endif
        </div>
    </header>

    <div class="container">
        <a href="/products" class="back-button">← Kembali ke Katalog</a>

        <div class="product-section">
            <div class="product-image">
                {{ $product->name[0] }}
            </div>

            <div class="product-details">
                <h1>{{ $product->name }}</h1>
                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                <div class="product-meta">
                    <span class="badge">{{ $product->condition === 'new' ? 'BARU' : 'BEKAS' }}</span>
                    
                    <div class="rating-display">
                        @php
                            $avgRating = $product->reviews->avg('rating') ?? 0;
                            $reviewCount = $product->reviews->count();
                            $fullStars = floor($avgRating);
                            $hasHalf = ($avgRating - $fullStars) >= 0.5;
                        @endphp
                        <div class="stars">
                            @for($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star filled"></i>
                            @endfor
                            @if($hasHalf)
                                <i class="fas fa-star-half-stroke filled"></i>
                            @endif
                            @for($i = 0; $i < (5 - $fullStars - ($hasHalf ? 1 : 0)); $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <span>{{ $reviewCount }} Reviews</span>
                    </div>

                    <div>
                        @php
                            $sold = $product->sold_count ?? 0;
                            $soldText = $sold >= 1000 ? floor($sold / 1000) . 'rb+' : $sold;
                        @endphp
                        <strong>{{ $soldText }} Terjual</strong>
                    </div>
                </div>

                <div class="product-info">
                    <h3>Deskripsi Produk</h3>
                    <p>{{ $product->description }}</p>

                    <h3>Informasi Produk</h3>
                    <table>
                        <tr>
                            <td><strong>Kategori:</strong></td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Berat:</strong></td>
                            <td>{{ $product->weight ?? '-' }} gram</td>
                        </tr>
                        <tr>
                            <td><strong>Kondisi:</strong></td>
                            <td>{{ $product->condition === 'new' ? 'Baru' : 'Bekas' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Lokasi:</strong></td>
                            <td>{{ $product->location_city }}, {{ $product->location_province }}</td>
                        </tr>
                        <tr>
                            <td><strong>Stok:</strong></td>
                            <td>{{ $product->stock }}</td>
                        </tr>
                    </table>

                    <h3>Penjual</h3>
                    <p><strong>{{ $product->seller->store_name ?? 'Unknown' }}</strong></p>
                    <p>{{ $product->seller->city ?? '' }}, {{ $product->seller->province ?? '' }}</p>
                </div>
            </div>
        </div>

        <div class="reviews-section">
            <div class="reviews-header">
                <div>
                    <h2 style="margin-bottom: 10px;">Reviews</h2>
                    @php
                        $avgRating = $product->reviews->avg('rating') ?? 0;
                        $reviewCount = $product->reviews->count();
                        $fullStars = floor($avgRating);
                        $hasHalf = ($avgRating - $fullStars) >= 0.5;
                    @endphp
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="font-size: 32px; font-weight: 800; color: #4A3B32;">{{ number_format($avgRating, 1) }}</div>
                        <div>
                            <div class="stars" style="font-size: 20px; margin-bottom: 5px;">
                                @for($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star filled"></i>
                                @endfor
                                @if($hasHalf)
                                    <i class="fas fa-star-half-stroke filled"></i>
                                @endif
                                @for($i = 0; $i < (5 - $fullStars - ($hasHalf ? 1 : 0)); $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </div>
                            <div style="font-size: 14px; color: #999;">Based on {{ $reviewCount }} reviews</div>
                        </div>
                    </div>
                </div>
                <button class="btn-write-review" onclick="openReviewModal()">
                    <i class="fas fa-plus"></i> Write a review
                </button>
            </div>

            @forelse($product->reviews as $review)
                <div class="review-item">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <div class="review-rating" style="font-size: 24px; margin-bottom: 10px;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="fas fa-star" style="color: #E5E5E5;"></i>
                                    @endif
                                @endfor
                            </div>
                            <h4 style="color: #4A3B32; font-size: 18px; font-weight: 700; margin-bottom: 10px;">{{ $review->review_title ?? 'Tanpa Judul' }}</h4>
                            <p class="review-comment" style="color: #555; line-height: 1.7; margin-bottom: 15px; font-size: 15px;">{{ $review->comment }}</p>
                            <p style="color: #8B9D3B; font-size: 13px; font-weight: 600;">{{ $review->reviewer_name }}, {{ $review->reviewer_province ?? 'Unknown' }}</p>
                        </div>
                        <div style="font-size: 13px; color: #999; text-align: right; white-space: nowrap; margin-left: 20px;">
                            {{ $review->created_at->format('d F Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-reviews">
                    <p>Belum ada review untuk produk ini. Jadilah yang pertama memberikan review!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeReviewModal()">&times;</button>
            <h2>Give Your Feedback</h2>

            <div class="star-rating" id="starRating">
                <i class="fas fa-star" data-rating="1"></i>
                <i class="fas fa-star" data-rating="2"></i>
                <i class="fas fa-star" data-rating="3"></i>
                <i class="fas fa-star" data-rating="4"></i>
                <i class="fas fa-star" data-rating="5"></i>
            </div>

            <form id="reviewForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="rating" id="selectedRating" value="">

                <div class="form-group">
                    <label>Review title <span class="required">*</span></label>
                    <input type="text" name="review_title" placeholder="Example: A very good product!" required>
                </div>

                <div class="form-group">
                    <label>Enter your review <span class="required">*</span></label>
                    <textarea name="comment" placeholder="Type your review here..." required></textarea>
                </div>

                <div class="form-group">
                    <label>Name <span class="required">*</span></label>
                    <input type="text" name="reviewer_name" required>
                </div>

                <div class="form-group">
                    <label>Phone Number <span class="required">*</span></label>
                    <input type="tel" name="reviewer_phone" required>
                </div>

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="reviewer_email" required>
                </div>

                <div class="form-group">
                    <label>Province <span class="required">*</span></label>
                    <select name="reviewer_province" id="reviewer_province" class="form-group-select select2" style="width: 540px;" required>
                        <option value=""></option>
                    </select>
                </div>

                <p class="form-hint">You will be able to receive emails in connection with this review.</p>

                <div class="modal-actions">
                    <button type="submit" class="btn-submit">Submit</button>
                    <button type="button" class="btn-cancel" onclick="closeReviewModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="success-modal">
        <div class="success-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>Terima Kasih!</h3>
            <p>Review Anda telah berhasil dikirim dan akan segera ditampilkan.</p>
            <button onclick="closeSuccessModal()">Kembali</button>
        </div>
    </div>

    <footer>
        <div class="footer-left">
            <p>
                <strong>Nestica</strong><br>
                (+62) 123 144 567<br>
                info@nestica.com
            </p>
        </div>
        <div class="footer-right">
            <p>
                &copy; 2025 Nestica<br>
                Made with love by kelompok 4
            </p>
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                minimumResultsForSearch: 0
            });

            var selectedProvince = "{{ request('province') }}";
            var selectedCity = "{{ request('city') }}";

            // Load Provinces for search bar
            $.get('/api/regions/provinces', function(data) {
                var provinceSelect = $('#province');
                $.each(data, function(index, province) {
                    var option = new Option(province.name, province.name);
                    $(option).attr('data-code', province.code);
                    if (province.name === selectedProvince) {
                        $(option).prop('selected', true);
                    }
                    provinceSelect.append(option);
                });
                provinceSelect.select2({
                    minimumResultsForSearch: 0
                });
                
                if (selectedProvince) {
                    var code = provinceSelect.find('option[value="'+selectedProvince+'"]').data('code');
                    if(code) loadCities(code);
                }
            });

            // Load Provinces for review modal
            $.get('/api/regions/provinces', function(data) {
                var provinceSelect = $('#reviewer_province');
                $.each(data, function(index, province) {
                    provinceSelect.append(new Option(province.name, province.name));
                });
                provinceSelect.select2({
                    minimumResultsForSearch: 0
                });
            });

            $('#province').on('change', function() {
                var code = $(this).find(':selected').data('code');
                loadCities(code);
            });

            function loadCities(code) {
                var citySelect = $('#city');
                citySelect.empty().append('<option value="">City</option>').prop('disabled', true);
                
                if (code) {
                    $.get('/api/regions/regencies/' + code, function(data) {
                        $.each(data, function(index, city) {
                            var option = new Option(city.name, city.name);
                            if (city.name === selectedCity) {
                                $(option).prop('selected', true);
                            }
                            citySelect.append(option);
                        });
                        citySelect.select2({
                            minimumResultsForSearch: 0
                        });
                        citySelect.prop('disabled', false);
                    });
                }
            }
        });

        let selectedRating = 0;

        // Star rating functionality
        const stars = document.querySelectorAll('#starRating .fa-star');
        stars.forEach(star => {
            star.addEventListener('click', function() {
                selectedRating = this.getAttribute('data-rating');
                document.getElementById('selectedRating').value = selectedRating;
                updateStars(selectedRating);
            });

            star.addEventListener('mouseover', function() {
                updateStars(this.getAttribute('data-rating'));
            });
        });

        document.getElementById('starRating').addEventListener('mouseout', function() {
            updateStars(selectedRating);
        });

        function updateStars(rating) {
            stars.forEach(star => {
                if (star.getAttribute('data-rating') <= rating) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }

        // Modal functions
        function openReviewModal() {
            document.getElementById('reviewModal').style.display = 'block';
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
            document.getElementById('reviewForm').reset();
            selectedRating = 0;
            updateStars(0);
        }

        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
            window.location.href = '/products/{{ $product->id }}';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('reviewModal');
            if (event.target == modal) {
                closeReviewModal();
            }
        }

        // Form submission
        document.getElementById('reviewForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!selectedRating) {
                alert('Silakan pilih rating terlebih dahulu!');
                return;
            }

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Mengirim...';

            try {
                const response = await fetch('/reviews', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    closeReviewModal();
                    document.getElementById('successModal').style.display = 'block';
                } else {
                    alert(data.message || 'Terjadi kesalahan saat mengirim review');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Submit';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal menghubungi server');
                submitBtn.disabled = false;
                submitBtn.innerText = 'Submit';
            }
        });
    </script>
</body>
</html>
