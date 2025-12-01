@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan Platform')

@section('content')
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        <div class="card">
            <h3 style="margin-bottom: 15px;">📊 Laporan Status Penjual</h3>
            <p style="color: #666; margin-bottom: 20px;">Laporan daftar penjual aktif dan tidak aktif</p>
            <a href="/reports/seller-status" class="btn btn-primary" target="_blank">Download PDF</a>
            <a href="/reports/preview/seller-status" class="btn btn-sm btn-warning" style="margin-top: 10px;" target="_blank">Preview JSON</a>
        </div>
        
        <div class="card">
            <h3 style="margin-bottom: 15px;">📍 Laporan Penjual per Provinsi</h3>
            <p style="color: #666; margin-bottom: 20px;">Daftar penjual untuk setiap lokasi provinsi</p>
            <div class="form-group">
                <label>Filter Provinsi (opsional)</label>
                <select id="provinceSelect" class="form-control select2" style="width: 100%;">
                    <option value="">Semua Provinsi</option>
                </select>
            </div>
            <button class="btn btn-primary" onclick="downloadProvinceReport()">Download PDF</button>
        </div>
        
        <div class="card">
            <h3 style="margin-bottom: 15px;">⭐ Laporan Produk & Rating</h3>
            <p style="color: #666; margin-bottom: 20px;">Daftar produk diurutkan berdasarkan rating</p>
            <div class="form-group">
                <label>Filter Kategori (opsional)</label>
                <select id="categorySelect" class="form-control">
                    <option value="">Semua Kategori</option>
                </select>
            </div>
            <button class="btn btn-primary" onclick="downloadProductReport()">Download PDF</button>
        </div>
    </div>
    
    <div class="card" style="margin-top: 20px;">
        <h3 style="margin-bottom: 20px;">📦 Laporan Penjual (Per Seller)</h3>
        <p style="color: #666; margin-bottom: 20px;">Pilih penjual untuk melihat laporan khusus</p>
        
        <div class="form-group">
            <label>Pilih Penjual</label>
            <select id="sellerSelect" class="form-control">
                <option value="">-- Pilih Penjual --</option>
            </select>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;" id="sellerReports" style="display: none;">
            <button class="btn btn-primary" onclick="downloadSellerStockReport()">Laporan Stok</button>
            <button class="btn btn-primary" onclick="downloadSellerRatingReport()">Laporan Stok by Rating</button>
            <button class="btn btn-danger" onclick="downloadLowStockReport()">Laporan Stok Habis</button>
        </div>
    </div>
@endsection

@section('extra-scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    async function loadProvinces() {
        try {
            const response = await fetch('/api/regions/provinces');
            const data = await response.json();
            
            const select = $('#provinceSelect');
            data.forEach(province => {
                select.append(new Option(province.name, province.name));
            });
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    async function loadCategories() {
        try {
            const response = await fetch('/products/categories', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();
            
            if (result.success) {
                const select = document.getElementById('categorySelect');
                result.data.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.name;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    async function loadSellers() {
        try {
            const response = await fetch('/sellers?status=approved', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();
            
            if (result.success) {
                const select = document.getElementById('sellerSelect');
                result.data.data.forEach(seller => {
                    const option = document.createElement('option');
                    option.value = seller.id;
                    option.textContent = seller.store_name;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    document.getElementById('sellerSelect').addEventListener('change', function() {
        document.getElementById('sellerReports').style.display = this.value ? 'grid' : 'none';
    });
    
    function downloadProvinceReport() {
        const province = document.getElementById('provinceSelect').value;
        const url = province ? `/reports/seller-by-province?province=${encodeURIComponent(province)}` : '/reports/seller-by-province';
        window.open(url, '_blank');
    }
    
    function downloadProductReport() {
        const category = document.getElementById('categorySelect').value;
        const url = category ? `/reports/product-rating?category_id=${category}` : '/reports/product-rating';
        window.open(url, '_blank');
    }
    
    function downloadSellerStockReport() {
        const sellerId = document.getElementById('sellerSelect').value;
        if (sellerId) window.open(`/seller-reports/${sellerId}/stock`, '_blank');
    }
    
    function downloadSellerRatingReport() {
        const sellerId = document.getElementById('sellerSelect').value;
        if (sellerId) window.open(`/seller-reports/${sellerId}/stock-by-rating`, '_blank');
    }
    
    function downloadLowStockReport() {
        const sellerId = document.getElementById('sellerSelect').value;
        if (sellerId) window.open(`/seller-reports/${sellerId}/low-stock`, '_blank');
    }
    
    loadProvinces();
    loadCategories();
    loadSellers();
</script>
@endsection
