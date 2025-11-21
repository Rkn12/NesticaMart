@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Laporan Toko</h2>
    
    <div class="card">
        <div class="card-body">
            <h5>Laporan Stok Produk</h5>
            <p>Unduh laporan stok produk di toko Anda</p>
            <button onclick="downloadReport('stock')" class="btn btn-primary">
                📄 Download Laporan Stok
            </button>
        </div>
    </div>
    
    <div class="card mt-3">
        <div class="card-body">
            <h5>Laporan Rating Produk</h5>
            <p>Unduh laporan rating dan review produk Anda</p>
            <button onclick="downloadReport('rating')" class="btn btn-primary">
                📄 Download Laporan Rating
            </button>
        </div>
    </div>
</div>

<script>
const sellerId = {{ Auth::user()->seller_id }};

function downloadReport(type) {
    let url = '';
    if (type === 'stock') {
        url = `/api/seller/reports/stock/${sellerId}`;
    } else if (type === 'rating') {
        url = `/api/seller/reports/rating/${sellerId}`;
    }
    window.open(url, '_blank');
}
</script>
@endsection
