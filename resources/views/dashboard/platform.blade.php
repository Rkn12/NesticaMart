@extends('layouts.app')

@section('title', 'Dashboard Platform')
@section('page-title', 'Dashboard Platform')

@section('extra-styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <h3 id="totalSellers">-</h3>
            <p>Total Penjual</p>
        </div>
        <div class="stat-card">
            <h3 id="totalProducts">-</h3>
            <p>Total Produk</p>
        </div>
        <div class="stat-card">
            <h3 id="totalReviews">-</h3>
            <p>Total Review</p>
        </div>
        <div class="stat-card">
            <h3 id="avgRating">-</h3>
            <p>Rata-rata Rating</p>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 20px;">Produk per Kategori</h3>
        <canvas id="categoryChart" style="max-height: 300px;"></canvas>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 20px;">Toko per Provinsi</h3>
        <canvas id="provinceChart" style="max-height: 300px;"></canvas>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="card">
            <h3 style="margin-bottom: 20px;">Status Penjual</h3>
            <canvas id="sellersChart"></canvas>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 20px;">Statistik Review</h3>
            <div id="reviewStats"></div>
        </div>
    </div>
    <div style="margin-left: -30px; margin-right: -30px; margin-bottom: 0; margin-top: 60px;">
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
    async function loadSummary() {
        try {
            const response = await fetch('/api/dashboard/summary', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();

            if (result.success) {
                const data = result.data;
                document.getElementById('totalSellers').textContent = data.total_sellers;
                document.getElementById('totalProducts').textContent = data.total_products;
                document.getElementById('totalReviews').textContent = data.total_reviews;
                document.getElementById('avgRating').textContent = data.average_rating + '/5';
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function loadCategoryChart() {
        try {
            const response = await fetch('/api/dashboard/products-by-category', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();

            if (result.success) {
                const data = result.data;
                const ctx = document.getElementById('categoryChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.map(item => item.category),
                        datasets: [{
                            label: 'Jumlah Produk',
                            data: data.map(item => item.total),
                            backgroundColor: 'rgba(102, 126, 234, 0.5)',
                            borderColor: 'rgba(102, 126, 234, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            y: {beginAtZero: true}
                        }
                    }
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function loadProvinceChart() {
        try {
            const response = await fetch('/api/dashboard/stores-by-province', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();

            if (result.success) {
                const data = result.data;
                const ctx = document.getElementById('provinceChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.map(item => item.province),
                        datasets: [{
                            label: 'Jumlah Toko',
                            data: data.map(item => item.total),
                            backgroundColor: 'rgba(118, 75, 162, 0.5)',
                            borderColor: 'rgba(118, 75, 162, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            y: {beginAtZero: true}
                        }
                    }
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function loadSellersChart() {
        try {
            const response = await fetch('/api/dashboard/sellers-status', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();

            if (result.success) {
                const data = result.data;
                const ctx = document.getElementById('sellersChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Approved', 'Pending', 'Rejected'],
                        datasets: [{
                            data: [data.approved, data.pending, data.rejected],
                            backgroundColor: [
                                'rgba(39, 174, 96, 0.7)',
                                'rgba(243, 156, 18, 0.7)',
                                'rgba(231, 76, 60, 0.7)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true
                    }
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function loadReviewStats() {
        try {
            const response = await fetch('/api/dashboard/reviewers-count', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();

            if (result.success) {
                const data = result.data;
                document.getElementById('reviewStats').innerHTML = `
                    <div style="padding: 20px; text-align: center;">
                        <h2 style="color: #667eea; margin-bottom: 10px;">${data.total_reviewers}</h2>
                        <p style="color: #666; margin-bottom: 20px;">Total Reviewer</p>

                        <h2 style="color: #764ba2; margin-bottom: 10px;">${data.total_reviews}</h2>
                        <p style="color: #666;">Total Review</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    loadSummary();
    loadCategoryChart();
    loadProvinceChart();
    loadSellersChart();
    loadReviewStats();
</script>
@endsection
