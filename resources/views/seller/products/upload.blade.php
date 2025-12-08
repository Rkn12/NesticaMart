@extends('layouts.app')

@section('title', 'Upload Product - Nestica')

@section('content')
<style>
    .upload-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .page-title {
        font-size: 28px;
        color: #483A2E;
        font-weight: bold;
        margin-bottom: 30px;
    }
    
    .upload-form-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .form-section {
        background: #FBFDF0;
        padding: 25px;
        border-radius: 15px;
        border: 1px solid #e0e0e0;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: bold;
        color: #483A2E;
        margin-bottom: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #483A2E;
        margin-bottom: 8px;
    }
    
    .form-input, .form-textarea, .form-select {
        width: 100%;
        padding: 12px;
        border: 1px solid #D5CDC2;
        border-radius: 8px;
        font-size: 14px;
        font-family: Arial, sans-serif;
        background: white;
        color: #483A2E;
    }
    
    .form-select {
        padding-right: 35px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23483A2E' d='M1.41 0L6 4.59L10.59 0L12 1.41l-6 6l-6-6z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
    }
    
    .form-input::placeholder,
    .form-textarea::placeholder {
        color: #7E991E;
    }
    
    .form-select {
        color: #7E991E;
    }
    
    .form-select option:first-child {
        color: #7E991E;
    }
    
    .form-select:valid {
        color: #483A2E;
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }
    
    .upload-area {
        border: 2px dashed #D5CDC2;
        border-radius: 8px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }
    
    .upload-area:hover {
        border-color: #7E991E;
        background: #FBFDF0;
    }
    
    .upload-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 10px;
    }
    
    .upload-icon svg {
        width: 100%;
        height: 100%;
        fill: #483A2E;
    }
    
    .upload-text {
        color: #7E991E;
        font-size: 14px;
        font-weight: 600;
    }
    
    .upload-input {
        display: none;
    }
    
    .btn-submit {
        background: #483A2E;
        color: white;
        padding: 14px 40px;
        border: none;
        border-radius: 25px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        float: right;
        transition: all 0.3s;
    }
    
    .btn-submit:hover {
        background: #362C23;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(72, 58, 46, 0.3);
    }
</style>

<div class="upload-container">
    <h1 class="page-title">Upload Product</h1>
    
    <form action="{{ route('seller.products.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="upload-form-wrapper">
            <!-- Left Column -->
            <div class="left-column">
                <!-- General Information -->
                <div class="form-section">
                    <h3 class="section-title">General Information</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-input" placeholder="Enter product name" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-textarea" placeholder="Enter product description" required></textarea>
                    </div>
                </div>
                
                <!-- Pricing and Stock -->
                <div class="form-section">
                    <h3 class="section-title">Pricing and Stock</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-input" placeholder="Enter product price" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-input" placeholder="Enter product stock" required>
                    </div>
                </div>
                
                <!-- Category -->
                <div class="form-section">
                    <h3 class="section-title">Category</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Product Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Click here to pick</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="right-column">
                <!-- Upload Image -->
                <div class="form-section">
                    <h3 class="section-title">Upload Image</h3>
                    
                    <div class="form-group">
                        <label for="product-image" class="upload-area">
                            <div class="upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                                </svg>
                            </div>
                            <div class="upload-text">Browse your image here</div>
                            <input type="file" id="product-image" name="images[]" class="upload-input" accept="image/*" multiple required>
                        </label>
                        <div id="product-preview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; margin-top: 15px;"></div>
                    </div>
                </div>
                
                <!-- Details & Material Description -->
                <div class="form-section">
                    <h3 class="section-title">Details & Material Description</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Material</label>
                        <input type="text" name="bahan" class="form-input" placeholder="e.g., Wood, Metal, Plastic">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Origin</label>
                        <input type="text" name="origin" class="form-input" placeholder="e.g., chestnut (Castanea sativa) from Slovenia">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Material Title</label>
                        <input type="text" name="material_title" class="form-input" placeholder="Enter material title">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Material Description</label>
                        <input type="text" name="material_description" class="form-input" placeholder="Enter material description">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Upload Image Material</label>
                        <label for="material-image" class="upload-area">
                            <div class="upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                                </svg>
                            </div>
                            <div class="upload-text">Browse your image here</div>
                            <input type="file" id="material-image" name="material_image" class="upload-input" accept="image/*">
                        </label>
                        <div id="material-preview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; margin-top: 15px;"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn-submit">Add Product</button>
    </form>
</div>

<!-- Success Notification -->
@if(session('success'))
<div id="success-notification" style="position: fixed; top: 20px; right: 20px; background: #7E991E; color: white; padding: 20px 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999; font-size: 14px; font-weight: 600; max-width: 400px;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <svg style="width: 24px; height: 24px; fill: white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
</div>
<script>
    setTimeout(function() {
        var notification = document.getElementById('success-notification');
        if (notification) {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.5s';
            setTimeout(function() { notification.remove(); }, 500);
        }
    }, 3000);
</script>
@endif

<script>
// Product Image Preview
document.getElementById('product-image').addEventListener('change', function(e) {
    const preview = document.getElementById('product-preview');
    preview.innerHTML = '';
    
    const files = Array.from(e.target.files);
    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100%';
            img.style.height = '100px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '8px';
            img.style.border = '2px solid #7E991E';
            preview.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
});

// Material image preview
document.getElementById('material-image').addEventListener('change', function(e) {
    const preview = document.getElementById('material-preview');
    preview.innerHTML = '';
    
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100%';
            img.style.height = '100px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '8px';
            img.style.border = '2px solid #7E991E';
            preview.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
});
</script>

<!-- Footer -->
<div style="margin-left: -30px; margin-right: -30px; margin-bottom: -30px; margin-top: 120px;">
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
