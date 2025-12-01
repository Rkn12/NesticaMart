@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard Toko Saya</h2>
        <div>
            <a href="{{ route('seller.products.upload.form') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Upload Produk Baru
            </a>
            <a href="{{ route('seller.products') }}" class="btn btn-outline-primary">
                <i class="fas fa-box"></i> Kelola Produk
            </a>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h5>Total Produk</h5>
                    <h2 id="totalProducts">-</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-success text-white">
                <div class="card-body">
                    <h5>Produk Terjual</h5>
                    <h2 id="totalSold">-</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-warning text-white">
                <div class="card-body">
                    <h5>Total Stok</h5>
                    <h2 id="totalStock">-</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-info text-white">
                <div class="card-body">
                    <h5>Rating Rata-rata</h5>
                    <h2 id="avgRating">-</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5>Produk per Kategori</h5>
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5>Rating Produk</h5>
                    <canvas id="ratingChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Load seller dashboard data
const sellerId = {{ Auth::user()->seller_id }};

fetch(`/api/seller/dashboard/${sellerId}`)
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('totalProducts').textContent = data.data.total_products;
            document.getElementById('totalSold').textContent = data.data.total_sold || 0;
            document.getElementById('totalStock').textContent = data.data.total_stock;
            document.getElementById('avgRating').textContent = data.data.average_rating.toFixed(1);
        }
    });
</script>
@endsection
