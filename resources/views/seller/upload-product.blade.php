@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i> Upload Produk Baru
                    </h5>
                    <small>Lengkapi informasi produk dengan detail untuk meningkatkan penjualan</small>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('seller.products.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Gambar Produk Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-images me-2"></i>Gambar Produk
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="images" class="form-label">Upload Gambar <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Maksimal 5 gambar, ukuran maksimal 2MB per gambar. Gambar pertama akan menjadi gambar utama.
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="image-preview" class="mt-2">
                                                    <div class="text-muted text-center p-3">
                                                        <i class="fas fa-camera fa-2x mb-2"></i>
                                                        <p>Preview gambar akan muncul di sini</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Dasar Produk -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-box me-2"></i>Informasi Dasar Produk
                                </h6>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="Contoh: Sepatu Sneakers Nike Air Max 270" required>
                                    <div class="form-text">Gunakan nama yang jelas dan mudah dicari</div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi Produk <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="6" required
                                              placeholder="Jelaskan detail produk, kondisi, keunggulan, dll. Minimal 50 karakter">{{ old('description') }}</textarea>
                                    <div class="form-text">
                                        <span id="desc-count">0</span>/50 karakter minimum
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="kondisi" class="form-label">Kondisi <span class="text-danger">*</span></label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="kondisi" id="kondisi_baru" value="baru" {{ old('kondisi') == 'baru' ? 'checked' : '' }} required>
                                        <label class="btn btn-outline-success" for="kondisi_baru">
                                            <i class="fas fa-star me-1"></i>Baru
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="kondisi" id="kondisi_bekas" value="bekas" {{ old('kondisi') == 'bekas' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning" for="kondisi_bekas">
                                            <i class="fas fa-recycle me-1"></i>Bekas
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Harga & Stok -->
                        <h6 class="text-primary mb-3">Harga & Stok</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" 
                                               min="100" required placeholder="10000">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" 
                                           min="1" required placeholder="10">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="berat" class="form-label">Berat (kg) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="berat" name="berat" value="{{ old('berat') }}" 
                                           step="0.1" min="0.1" required placeholder="0.5">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Detail Produk -->
                        <h6 class="text-primary mb-3">Detail Produk</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kondisi" class="form-label">Kondisi <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kondisi" name="kondisi" required>
                                        <option value="">Pilih Kondisi</option>
                                        <option value="baru" {{ old('kondisi') == 'baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="bekas" {{ old('kondisi') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="merek" class="form-label">Merek</label>
                                    <input type="text" class="form-control" id="merek" name="merek" value="{{ old('merek') }}" 
                                           placeholder="Contoh: Nike, Samsung, dll">
                                </div>

                                <div class="mb-3">
                                    <label for="bahan" class="form-label">Bahan</label>
                                    <input type="text" class="form-control" id="bahan" name="bahan" value="{{ old('bahan') }}" 
                                           placeholder="Contoh: Kulit asli, Katun, Plastik, dll">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="garansi" class="form-label">Garansi</label>
                                    <input type="text" class="form-control" id="garansi" name="garansi" value="{{ old('garansi') }}" 
                                           placeholder="Contoh: Garansi resmi 1 tahun">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Dimensi (cm)</label>
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="number" class="form-control" name="dimensi_panjang" 
                                                   value="{{ old('dimensi_panjang') }}" placeholder="Panjang" step="0.1">
                                        </div>
                                        <div class="col-4">
                                            <input type="number" class="form-control" name="dimensi_lebar" 
                                                   value="{{ old('dimensi_lebar') }}" placeholder="Lebar" step="0.1">
                                        </div>
                                        <div class="col-4">
                                            <input type="number" class="form-control" name="dimensi_tinggi" 
                                                   value="{{ old('dimensi_tinggi') }}" placeholder="Tinggi" step="0.1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Lokasi -->
                        <h6 class="text-primary mb-3">Lokasi</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location_province" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                    <select class="form-select" id="location_province" name="location_province" required>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location_city" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                                    <select class="form-select" id="location_city" name="location_city" required disabled>
                                        <option value="">Pilih Kota/Kabupaten</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Spesifikasi Tambahan -->
                        <h6 class="text-primary mb-3">Spesifikasi Tambahan</h6>
                        <div id="spesifikasi-container">
                            <div class="row mb-2 spesifikasi-row">
                                <div class="col-5">
                                    <input type="text" class="form-control" name="spesifikasi[0][key]" placeholder="Nama spesifikasi">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="spesifikasi[0][value]" placeholder="Nilai spesifikasi">
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="addSpesifikasi()">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-text">Tambahkan spesifikasi seperti ukuran, warna, model, dll</div>

                        <hr>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-secondary me-md-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Load provinces when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadProvinces();
});

// Load provinces
function loadProvinces() {
    const provinceSelect = document.getElementById('location_province');
    
    // Add loading option
    provinceSelect.innerHTML = '<option value="">Memuat provinsi...</option>';
    
    fetch('/api/provinces')
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Provinces data:', data);
            provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
            
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.dataset.code = province.code;
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });
            } else {
                provinceSelect.innerHTML = '<option value="">Data provinsi tidak tersedia</option>';
            }
        })
        .catch(error => {
            console.error('Error loading provinces:', error);
            provinceSelect.innerHTML = '<option value="">Error loading provinces</option>';
        });
}

// Province change event - load cities
document.getElementById('location_province').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const selectedProvince = this.value;
    const provinceCode = selectedOption.dataset.code;
    const citySelect = document.getElementById('location_city');
    
    // Reset city dropdown
    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
    citySelect.disabled = true;
    
    if (selectedProvince && provinceCode) {
        citySelect.innerHTML = '<option value="">Memuat kota/kabupaten...</option>';
        
        fetch(`/api/provinces/${provinceCode}/regencies`)
            .then(response => response.json())
            .then(cities => {
                console.log('Cities data:', cities);
                citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                
                if (Array.isArray(cities) && cities.length > 0) {
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                    citySelect.disabled = false;
                } else {
                    citySelect.innerHTML = '<option value="">Data kota tidak tersedia</option>';
                }
            })
            .catch(error => {
                console.error('Error loading cities:', error);
                citySelect.innerHTML = '<option value="">Error loading cities</option>';
            });
    }
});

// Image preview
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    
    const files = Array.from(e.target.files);
    files.forEach((file, index) => {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-image-container d-inline-block me-2 mb-2';
                div.innerHTML = `
                    <img src="${e.target.result}" class="preview-image" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                    <small class="d-block text-center">${index + 1}</small>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });
});

// Spesifikasi management
let spesifikasiCount = 1;
function addSpesifikasi() {
    const container = document.getElementById('spesifikasi-container');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 spesifikasi-row';
    newRow.innerHTML = `
        <div class="col-5">
            <input type="text" class="form-control" name="spesifikasi[${spesifikasiCount}][key]" placeholder="Nama spesifikasi">
        </div>
        <div class="col-6">
            <input type="text" class="form-control" name="spesifikasi[${spesifikasiCount}][value]" placeholder="Nilai spesifikasi">
        </div>
        <div class="col-1">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeSpesifikasi(this)">-</button>
        </div>
    `;
    container.appendChild(newRow);
    spesifikasiCount++;
}

function removeSpesifikasi(button) {
    button.closest('.spesifikasi-row').remove();
}

// Format currency
document.getElementById('price').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\d]/g, '');
    if (value) {
        e.target.value = value;
    }
});
</script>

<style>
.preview-image-container {
    position: relative;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.text-danger {
    color: #dc3545 !important;
}

.form-text {
    font-size: 0.875em;
    color: #6c757d;
}
</style>
@endsection