@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Upload Produk</h2>
            <p class="text-gray-600 mb-6">Tambahkan produk baru ke toko Anda</p>

            <form id="productUploadForm" enctype="multipart/form-data">
                @csrf

                <!-- Informasi Produk -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b-2 border-purple-500">Informasi Produk</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Toko Penjual <span class="text-red-500">*</span></label>
                        <select name="seller_id" id="seller_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            <option value="">-- Pilih Toko --</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Kategori Produk <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            <option value="">-- Pilih Kategori --</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Deskripsi Produk <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="price" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Berat (gram)</label>
                            <input type="number" name="weight" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Kondisi <span class="text-red-500">*</span></label>
                        <div class="flex gap-6">
                            <label class="flex items-center">
                                <input type="radio" name="condition" value="new" class="mr-2" required>
                                <span>Baru</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="condition" value="used" class="mr-2">
                                <span>Bekas</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Lokasi Produk -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b-2 border-purple-500">Lokasi Produk</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Provinsi <span class="text-red-500">*</span></label>
                            <select name="location_province" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                                <option value="">-- Pilih Provinsi --</option>
                                <option value="DKI Jakarta">DKI Jakarta</option>
                                <option value="Jawa Barat">Jawa Barat</option>
                                <option value="Jawa Tengah">Jawa Tengah</option>
                                <option value="Jawa Timur">Jawa Timur</option>
                                <option value="Bali">Bali</option>
                                <option value="Sumatera Utara">Sumatera Utara</option>
                                <option value="Sumatera Selatan">Sumatera Selatan</option>
                                <option value="Kalimantan Timur">Kalimantan Timur</option>
                                <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Kota/Kabupaten <span class="text-red-500">*</span></label>
                            <input type="text" name="location_city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                    </div>
                </div>

                <!-- Gambar Produk -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b-2 border-purple-500">Gambar Produk</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Upload Gambar (Maksimal 5 gambar)</label>
                        <input type="file" name="images[]" id="productImages" accept="image/jpeg,image/png,image/jpg" multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG. Max: 2MB per file. Gambar pertama akan menjadi gambar utama.</p>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4"></div>
                </div>

                <!-- Alert Messages -->
                <div id="alertMessage" class="hidden mb-4 p-4 rounded-lg"></div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-lg hover:from-purple-600 hover:to-pink-600 transition">
                        Upload Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Load sellers dan categories saat halaman load
document.addEventListener('DOMContentLoaded', async function() {
    try {
        // Load approved sellers
        const sellersResponse = await fetch('/api/sellers?status=approved');
        const sellersData = await sellersResponse.json();
        
        const sellerSelect = document.getElementById('seller_id');
        if (sellersData.success && sellersData.data) {
            const sellers = sellersData.data.data || sellersData.data;
            sellers.forEach(seller => {
                const option = document.createElement('option');
                option.value = seller.id;
                option.textContent = seller.store_name;
                sellerSelect.appendChild(option);
            });
        }

        // Load categories
        const categoriesResponse = await fetch('/api/products/categories');
        const categoriesData = await categoriesResponse.json();
        
        const categorySelect = document.getElementById('category_id');
        if (categoriesData.success && categoriesData.data) {
            categoriesData.data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error loading data:', error);
    }
});

// Image preview
document.getElementById('productImages').addEventListener('change', function(e) {
    const previewDiv = document.getElementById('imagePreview');
    previewDiv.innerHTML = '';
    
    const files = Array.from(e.target.files).slice(0, 5); // Max 5 images
    
    files.forEach((file, index) => {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border-2 ${index === 0 ? 'border-purple-500' : 'border-gray-300'}">
                ${index === 0 ? '<span class="absolute top-1 left-1 bg-purple-500 text-white text-xs px-2 py-1 rounded">Utama</span>' : ''}
            `;
            previewDiv.appendChild(div);
        };
        
        reader.readAsDataURL(file);
    });
});

// Form submission
document.getElementById('productUploadForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const alertDiv = document.getElementById('alertMessage');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    // Disable submit button
    submitBtn.disabled = true;
    submitBtn.textContent = 'Mengupload...';
    
    try {
        const response = await fetch('/api/products', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alertDiv.className = 'mb-4 p-4 rounded-lg bg-green-100 border border-green-400 text-green-700';
            alertDiv.textContent = result.message;
            alertDiv.classList.remove('hidden');
            
            // Redirect after 2 seconds
            setTimeout(() => {
                window.location.href = '/products';
            }, 2000);
        } else {
            let errorMsg = 'Terjadi kesalahan: ';
            if (result.errors) {
                errorMsg += Object.values(result.errors).flat().join(', ');
            } else {
                errorMsg += result.message || 'Silakan coba lagi';
            }
            
            alertDiv.className = 'mb-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700';
            alertDiv.textContent = errorMsg;
            alertDiv.classList.remove('hidden');
            
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = 'Upload Produk';
        }
    } catch (error) {
        alertDiv.className = 'mb-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700';
        alertDiv.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
        alertDiv.classList.remove('hidden');
        
        // Re-enable submit button
        submitBtn.disabled = false;
        submitBtn.textContent = 'Upload Produk';
    }
});
</script>
@endsection
