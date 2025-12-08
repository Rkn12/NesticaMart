<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Nestica</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
            align-items: center;
            text-decoration: none;
            color: #4A3B32;
        }

        .logo img {
            height: 80px;
            width: 80px;
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

        

        /* Products Section */
        .products-section {
            padding: 40px 60px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 32px;
            font-weight: 800;
            color: #4A3B32;
            text-transform: uppercase;
        }

        .btn-add-product {
            background-color: #4A3B32;
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }

        .product-card {
            background: transparent;
            border: none;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image-container {
            width: 100%;
            height: 250px;
            background-color: #E8E8E0;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-location {
            font-size: 12px;
            color: #4A3B32;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
        }

        .product-title {
            font-size: 18px;
            font-weight: 700;
            color: #4A3B32;
            margin-bottom: 5px;
        }

        .product-price {
            font-size: 14px;
            color: #4A3B32;
            margin-bottom: 5px;
        }

        .product-store {
            font-size: 14px;
            color: #4A3B32;
            margin-bottom: 5px;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            color: #4A3B32;
        }

        .stars {
            color: #E5E5E5; /* Inactive star color */
        }
        
        .stars .filled {
            color: #F4D03F; /* Active star color */
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
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 40px;
        }
        
        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #4A3B32;
            color: #4A3B32;
            text-decoration: none;
            border-radius: 4px;
        }
        
        .pagination .active {
            background-color: #4A3B32;
            color: #fff;
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
                <img src="{{ asset('images/nestica-logo.png') }}" alt="Nestica Logo">
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
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <!-- Using Select2 for Province -->
                <select name="province" id="province" class="search-input select2" style="width: 140px;">
                    <option value="">Province</option>
                </select>
            </div>

            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <!-- Using Select2 for City but styled small -->
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

    

    <div class="products-section">
        <div class="section-header">
            <h2 class="section-title">PRODUCTS</h2>
            @if(Auth::check())
                <a href="{{ route('seller.products.upload.form') }}" class="btn-add-product">
                    <i class="fas fa-plus"></i> Add Your Products
                </a>
            @endif
        </div>

        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card" onclick="window.location.href='{{ route('products.show', $product->id) }}'">
                    <!-- Location -->
                    <div class="product-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $product->seller->city ?? 'Unknown City' }}, {{ $product->seller->province ?? 'Unknown Province' }}
                    </div>
                    
                    <!-- Product Image -->
                    @php
                        $firstImage = $product->images->first();
                        $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_url) : 'https://via.placeholder.com/400x250/D5CDC2/483A2E?text=No+Image';
                    @endphp
                    <div class="product-image-container">
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="product-image">
                    </div>
                    
                    <!-- Title -->
                    <h3 class="product-title">{{ $product->name }}</h3>
                    
                    <!-- Price -->
                    <div class="product-price">Rp. {{ number_format($product->price, 0, ',', '.') }}</div>
                    
                    <!-- Store Name -->
                    <div class="product-store">{{ $product->seller->store_name ?? 'Unknown Store' }}</div>
                    
                    <!-- Rating -->
                    <div class="product-rating">
                        @php
                            $avgRating = $product->reviews->avg('rating') ?? 0;
                            $reviewCount = $product->reviews->count();
                            $fullStars = floor($avgRating);
                            $hasHalf = ($avgRating - $fullStars) >= 0.5;
                        @endphp
                        <div class="stars">
                            {{-- Full stars --}}
                            @for($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star filled"></i>
                            @endfor

                            {{-- Half star --}}
                            @if($hasHalf)
                                <i class="fas fa-star-half-stroke filled"></i>
                            @endif

                            {{-- Empty stars --}}
                            @for($i = 0; $i < (5 - $fullStars - ($hasHalf ? 1 : 0)); $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <span>({{ $reviewCount }})</span>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #888;">
                    <p>No products found matching your criteria.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="pagination">
                {{ $products->appends(request()->query())->links('pagination::simple-default') }} 
                <!-- Or custom pagination links if needed, but simple-default usually works well enough or we can style the default output -->
            </div>
        @endif
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

            // Load Provinces
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
                    // Trigger change to load cities, but we need to find the code first
                    // Since we just appended, we can find it by value
                    var code = provinceSelect.find('option[value="'+selectedProvince+'"]').data('code');
                    if(code) loadCities(code);
                }
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
    </script>
</body>
</html>
