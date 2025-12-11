@extends('layouts.app')

@section('title', 'Store Reports - Nestica')

@section('content')
<style>
    .reports-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .page-title {
        font-size: 28px;
        color: #483A2E;
        font-weight: bold;
        margin-bottom: 30px;
    }
    
    .report-card {
        background: #FBFDF0;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 20px;
        border: 1px solid #D5CDC2;
    }
    
    .report-title {
        font-size: 20px;
        font-weight: bold;
        color: #483A2E;
        margin-bottom: 10px;
    }
    
    .report-description {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    
    .btn-download {
        background: #483A2E;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-download:hover {
        background: #362C23;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>

<div class="reports-container">
    <h1 class="page-title">Store Reports</h1>
    
    <div class="report-card">
        <h3 class="report-title">Product Stock Report</h3>
        <p class="report-description">Download a comprehensive report of your product inventory and stock levels</p>
        <button onclick="downloadSellerStockReport()" class="btn-download">
            Download Stock Report
        </button>
    </div>
    
    <div class="report-card">
        <h3 class="report-title">Product Rating Report</h3>
        <p class="report-description">Download a detailed report of product ratings and customer reviews</p>
        <button onclick="downloadSellerRatingReport()" class="btn-download">
            Download Rating Report
        </button>
    </div>

    <div class="report-card">
        <h3 class="report-title">Low Stock Product Report</h3>
        <p class="report-description">Download a detailed report of products with low stock levels</p>
        <button onclick="downloadLowStockReport()" class="btn-download">
            Download Low Stock Product Report
        </button>
    </div>
</div>

<script>
    const sellerId = {{ Auth::user()->seller_id }};

    function downloadSellerStockReport() {
        if (sellerId) window.open(`/seller-reports/${sellerId}/stock`, '_blank');
    }
    
    function downloadSellerRatingReport() {
        if (sellerId) window.open(`/seller-reports/${sellerId}/stock-by-rating`, '_blank');
    }
    
    function downloadLowStockReport() {
        if (sellerId) window.open(`/seller-reports/${sellerId}/low-stock`, '_blank');
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
