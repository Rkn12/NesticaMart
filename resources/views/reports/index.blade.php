@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan Platform')

@section('content')
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        <div class="card">
            <h3 style="margin-bottom: 15px; color: #483A2E;">Seller Status Report</h3>
            <p style="color: #666; margin-bottom: 20px;">List of active and inactive sellers</p>
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Filter Status</label>
                <select id="sellerStatusFilter" class="form-control">
                    <option value="all">See All Statuses</option>
                    <option value="active">Active Only</option>
                    <option value="inactive">Inactive Only</option>
                </select>
            </div>
            <button class="btn btn-primary" onclick="downloadSellerReport()">Download PDF</button>
            <a href="/admin/sellers/report" class="btn btn-sm btn-secondary" style="margin-top: 10px;" target="_blank">Lihat Detail</a>
        </div>
        
        <div class="card">
            <h3 style="margin-bottom: 15px; color: #483A2E;">Seller Report by Province</h3>
            <p style="color: #666; margin-bottom: 20px;">List of sellers by Province</p>
            <div class="form-group">
                <label>Filter Province (optional)</label>
                <select id="provinceSelect" class="form-control select2" style="width: 100%;">
                    <option value="">See All Provinces</option>
                </select>
            </div>
            <button class="btn btn-primary" onclick="downloadProvinceReport()">Download PDF</button>
        </div>
        
        <div class="card">
            <h3 style="margin-bottom: 15px; color: #483A2E;">Product & Rating Report</h3>
            <p style="color: #666; margin-bottom: 20px;">List of products sorted by rating</p>
            <div class="form-group">
                <label>Filter Category (optional)</label>
                <select id="categorySelect" class="form-control">
                    <option value="">See All Categories</option>
                </select>
            </div>
            <button class="btn btn-primary" onclick="downloadProductReport()">Download PDF</button>
        </div>
    </div>
    
    <div class="card" style="margin-top: 20px;">
        <h3 style="margin-bottom: 20px; color: #483A2E;">Seller Report (Per Seller)</h3>
        <p style="color: #666; margin-bottom: 20px;">Select a Seller to view a detailed report</p>
        
        <div class="form-group">
            <label>Select Seller</label>
            <select id="sellerSelect" class="form-control">
                <option value="">-- Select Seller --</option>
            </select>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;" id="sellerReports" style="display: none;">
            <button class="btn btn-primary" onclick="downloadSellerStockReport()">Product List Report By Stock</button>
            <button class="btn btn-primary" onclick="downloadSellerRatingReport()">Product List Report By Rating</button>
            <button class="btn btn-primary" onclick="downloadLowStockReport()">Low Stock Product Report</button>
        </div>
    </div>

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
            const response = await fetch('/reports/sellers-list', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();
            
            if (result.success) {
                const select = document.getElementById('sellerSelect');
                result.data.forEach(seller => {
                    const option = document.createElement('option');
                    option.value = seller.id;
                    option.textContent = `${seller.store_name} (${seller.city}, ${seller.province})`;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error loading sellers:', error);
        }
    }
    
    document.getElementById('sellerSelect').addEventListener('change', function() {
        document.getElementById('sellerReports').style.display = this.value ? 'grid' : 'none';
    });
    
    function downloadSellerReport() {
        const status = document.getElementById('sellerStatusFilter').value;
        const url = `/reports/seller-status?status=${status}`;
        window.open(url, '_blank');
    }
    
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
