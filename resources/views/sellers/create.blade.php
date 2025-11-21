@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Registrasi Penjual</h2>
            <p class="text-gray-600 mb-6">Lengkapi form berikut untuk mendaftar sebagai penjual</p>

            <form id="sellerRegistrationForm" enctype="multipart/form-data">
                @csrf

                <!-- Informasi Toko -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b-2 border-purple-500">Informasi Toko</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Nama Toko <span class="text-red-500">*</span></label>
                        <input type="text" name="store_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Deskripsi Toko</label>
                        <textarea name="store_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                    </div>
                </div>

                <!-- Informasi Pemilik -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b-2 border-purple-500">Informasi Pemilik</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Nama Pemilik <span class="text-red-500">*</span></label>
                        <input type="text" name="owner_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">NIK <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" maxlength="20" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">No. Telepon <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    </div>
                </div>

                <!-- Lokasi Toko -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b-2 border-purple-500">Lokasi Toko</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Provinsi <span class="text-red-500">*</span></label>
                            <select name="province" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
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
                            <input type="text" name="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Kecamatan <span class="text-red-500">*</span></label>
                            <input type="text" name="subdistrict" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Kelurahan <span class="text-red-500">*</span></label>
                            <input type="text" name="kelurahan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">RT <span class="text-red-500">*</span></label>
                                <input type="text" name="rt" maxlength="5" placeholder="001" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">RW <span class="text-red-500">*</span></label>
                                <input type="text" name="rw" maxlength="5" placeholder="001" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required></textarea>
                    </div>
                </div>

                <!-- Person In Charge (PIC) -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b-2 border-purple-500">Penanggung Jawab (PIC)</h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Nama PIC <span class="text-red-500">*</span></label>
                        <input type="text" name="pic_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">No. Telepon PIC <span class="text-red-500">*</span></label>
                            <input type="text" name="pic_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email PIC <span class="text-red-500">*</span></label>
                            <input type="email" name="pic_email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Foto KTP PIC</label>
                            <input type="file" name="foto_ktp_pic" accept="image/jpeg,image/png,image/jpg" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG. Max: 2MB</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">File KTP PIC (PDF)</label>
                            <input type="file" name="file_ktp_pic" accept="application/pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Format: PDF. Max: 5MB</p>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div id="alertMessage" class="hidden mb-4 p-4 rounded-lg"></div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('sellers.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-lg hover:from-purple-600 hover:to-pink-600 transition">
                        Daftar Sebagai Penjual
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('sellerRegistrationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const alertDiv = document.getElementById('alertMessage');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    // Disable submit button
    submitBtn.disabled = true;
    submitBtn.textContent = 'Mendaftar...';
    
    try {
        const response = await fetch('/api/sellers/register', {
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
                window.location.href = '{{ route("sellers.index") }}';
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
            submitBtn.textContent = 'Daftar Sebagai Penjual';
        }
    } catch (error) {
        alertDiv.className = 'mb-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700';
        alertDiv.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
        alertDiv.classList.remove('hidden');
        
        // Re-enable submit button
        submitBtn.disabled = false;
        submitBtn.textContent = 'Daftar Sebagai Penjual';
    }
});
</script>
@endsection
