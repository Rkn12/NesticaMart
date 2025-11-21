@extends('layouts.app')

@section('title', 'Tulis Review')
@section('page-title', 'Tulis Review')

@section('content')
    <div class="card">
        <a href="/products/{{ $product->id }}" class="btn btn-primary" style="width: fit-content; margin-bottom: 20px; padding: 12px 24px; font-size: 16px;">← Kembali ke Produk</a>
        
        <div style="display: flex; gap: 30px; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #eee;">
            <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                📦
            </div>
            <div style="flex: 1;">
                <h3 style="margin-bottom: 5px;">{{ $product->name }}</h3>
                <p style="color: #667eea; font-size: 20px; font-weight: bold; margin-bottom: 5px;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                <p style="color: #999; font-size: 14px;">{{ $product->seller->store_name ?? 'Unknown' }}</p>
            </div>
        </div>

        <h3 style="margin-bottom: 20px;">Tulis Review Produk</h3>
        
        @if(session('success'))
            <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="/reviews" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            <div class="form-group">
                <label>Nama Lengkap <span style="color: red;">*</span></label>
                <input type="text" name="reviewer_name" class="form-control" value="{{ old('reviewer_name') }}" required placeholder="Masukkan nama lengkap Anda">
            </div>
            
            <div class="form-group">
                <label>Nomor HP/WhatsApp <span style="color: red;">*</span></label>
                <input type="text" name="reviewer_phone" class="form-control" value="{{ old('reviewer_phone') }}" required placeholder="08xxxxxxxxxx">
            </div>
            
            <div class="form-group">
                <label>Provinsi <span style="color: red;">*</span></label>
                <input type="text" name="reviewer_province" class="form-control" value="{{ old('reviewer_province') }}" required placeholder="Contoh: DKI Jakarta, Jawa Barat, dll">
            </div>
            
            <div class="form-group">
                <label>Email <span style="color: red;">*</span></label>
                <input type="email" name="reviewer_email" class="form-control" value="{{ old('reviewer_email') }}" required placeholder="email@example.com">
            </div>
            
            <div class="form-group">
                <label>Rating <span style="color: red;">*</span></label>
                <select name="rating" class="form-control" required>
                    <option value="">Pilih Rating</option>
                    <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5) - Sangat Baik</option>
                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐☆ (4) - Baik</option>
                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐☆☆ (3) - Cukup</option>
                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐☆☆☆ (2) - Kurang</option>
                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐☆☆☆☆ (1) - Buruk</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Komentar</label>
                <textarea name="comment" class="form-control" rows="5" placeholder="Ceritakan pengalaman Anda dengan produk ini...">{{ old('comment') }}</textarea>
                <small style="color: #999;">Opsional - Bagikan pendapat Anda untuk membantu pembeli lain</small>
            </div>

            <div class="form-group">
                <label>Foto Produk (Opsional)</label>
                <input type="file" name="photos[]" class="form-control" multiple accept="image/*" id="photoInput">
                <small style="color: #999;">Maksimal 5 foto (JPG, PNG, max 2MB per foto)</small>
                <div id="photoPreview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; margin-top: 10px;"></div>
            </div>

            <div class="form-group">
                <label>Video Review (Opsional)</label>
                <input type="file" name="video" class="form-control" accept="video/*" id="videoInput">
                <small style="color: #999;">Maksimal 1 video (MP4, max 20MB)</small>
                <div id="videoPreview" style="margin-top: 10px;"></div>
            </div>
            
            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="flex: 1; padding: 15px; font-size: 16px; font-weight: 600;">
                    ✉️ Kirim Review
                </button>
                <a href="/products/{{ $product->id }}" class="btn" style="flex: 1; padding: 15px; font-size: 16px; font-weight: 600; background: #f5f5f5; color: #666; text-align: center; text-decoration: none; border: none;">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

@section('extra-scripts')
<script>
    // Preview foto
    document.getElementById('photoInput').addEventListener('change', function(e) {
        const preview = document.getElementById('photoPreview');
        preview.innerHTML = '';
        
        if (e.target.files.length > 5) {
            alert('Maksimal 5 foto!');
            e.target.value = '';
            return;
        }
        
        Array.from(e.target.files).forEach(file => {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran foto ' + file.name + ' melebihi 2MB!');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.style.width = '100%';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '8px';
                img.style.border = '2px solid #e0e0e0';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
    
    // Preview video
    document.getElementById('videoInput').addEventListener('change', function(e) {
        const preview = document.getElementById('videoPreview');
        preview.innerHTML = '';
        
        const file = e.target.files[0];
        if (file) {
            if (file.size > 20 * 1024 * 1024) {
                alert('Ukuran video melebihi 20MB!');
                e.target.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(event) {
                const video = document.createElement('video');
                video.src = event.target.result;
                video.controls = true;
                video.style.width = '100%';
                video.style.maxWidth = '400px';
                video.style.borderRadius = '8px';
                video.style.border = '2px solid #e0e0e0';
                preview.appendChild(video);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
