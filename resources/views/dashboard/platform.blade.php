@extends('layouts.app')

@section('title', 'Dashboard Platform')
@section('page-title', 'Dashboard Platform')

@section('extra-styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .dashboard-header-banner {
        background: #9ABA3E;
        color: white;
        padding: 8px 20px;
        margin: -20px -20px 20px -20px;
        font-size: 11px;
        text-align: center;
        font-weight: normal;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .page-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #E0E0E0;
    }

    .page-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .page-logo img {
        max-height: 50px;
        width: auto;
        object-fit: contain;
        display: block;
    }

    .page-title-section h1 {
        font-size: 28px;
        color: #483A2E;
        margin: 0;
        font-weight: bold;
    }

    .page-subtitle {
        font-size: 13px;
        color: #666;
        margin-top: 2px;
    }

    .chart-card {
        background: #FBF9F3;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 22px;
        color: #483A2E;
        font-weight: bold;
        margin: 0 0 5px 0;
    }

    .chart-subtitle {
        font-size: 14px;
        color: #9ABA3E;
        margin: 0 0 25px 0;
    }

    .dashboard-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
   

    <div class="page-header">
        <div class="page-logo">
            <img src="{{ asset('images/nestica-logo.png') }}" alt="Nestica Logo">
        </div>
        <div class="page-title-section">
            <h1>Dashboard Platform</h1>
            <div class="page-subtitle">Welcome back to your dashboard.</div>
        </div>
    </div>
    <div class="stats-grid">
        <div class="stat-card">
            <h3 id="totalSellers">-</h3>
            <p>Total Product</p>
        </div>
        <div class="stat-card">
            <h3 id="totalProducts">-</h3>
            <p>Total Store</p>
        </div>
        <div class="stat-card">
            <h3 id="totalReviews">-</h3>
            <p>Total User</p>
        </div>
        <div class="stat-card">
            <h3 id="avgRating">-</h3>
            <p>Total Comment & Rating</p>
        </div>
    </div>
    
    <div class="dashboard-row">
        <div class="card">
            <h2 class="chart-title">Products per Category</h2>
            <p class="chart-subtitle">Distribution of Products by Category</p>
            <canvas id="categoryChart" style="max-height: 350px;"></canvas>
        </div>
        
        <div class="card">
            <h2 class="chart-title" style="margin-bottom: 40px;">Stores Location</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: flex-start;">
                <div style="max-height: 250px; width: 250px; margin: 0 auto;">
                    <canvas id="storesLocationChart"></canvas>
                </div>
                <div id="storesLocationLegend" style="padding-top: 30px; text-align: right;"></div>
            </div>
        </div>
    </div>
    
    <div class="dashboard-row">
        <div class="card">
            <h2 class="chart-title" style="margin-bottom: 30px;">Seller Status</h2>
            <div style="padding: 20px 0;">
                <div style="margin-bottom: 40px;">
                    <p style="color: #9ABA3E; font-size: 18px; font-weight: 600; margin: 0 0 8px 0;">Active Sellers</p>
                    <h3 style="color: #483A2E; font-size: 48px; font-weight: bold; margin: 0;" id="activeSellersCount">-</h3>
                </div>
                <div>
                    <p style="color: #9ABA3E; font-size: 18px; font-weight: 600; margin: 0 0 8px 0;">Inactive Sellers</p>
                    <h3 style="color: #483A2E; font-size: 48px; font-weight: bold; margin: 0;" id="inactiveSellersCount">-</h3>
                </div>
            </div>
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
                            label: '',
                            data: data.map(item => item.total),
                            backgroundColor: '#483A2E',
                            borderRadius: 8,
                            barThickness: 80
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    color: '#483A2E',
                                    font: {
                                        size: 12
                                    }
                                },
                                grid: {
                                    color: '#9ABA3E',
                                    lineWidth: 1.5
                                },
                                border: {
                                    display: false
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#483A2E',
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    }
                                },
                                grid: {
                                    display: false
                                },
                                border: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    async function loadStoresLocationChart() {
        try {
            const response = await fetch('/api/dashboard/stores-by-province', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();
            
            if (result.success) {
                const data = result.data;
                const ctx = document.getElementById('storesLocationChart').getContext('2d');
                
                const colors = ['#6B4226', '#9ABA3E', '#F4D06F', '#D5CDC2'];
                
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.map(item => item.province),
                        datasets: [{
                            data: data.map(item => item.total),
                            backgroundColor: colors,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
                
                // Generate custom legend
                let legendHTML = '';
                data.forEach((item, index) => {
                    legendHTML += `
                        <div style="display: flex; align-items: center; margin-bottom: 12px;">
                            <div style="width: 20px; height: 20px; background: ${colors[index]}; border-radius: 3px; margin-right: 10px;"></div>
                            <span style="color: #483A2E; font-weight: 500; font-size: 14px;">${item.province} (${item.total})</span>
                        </div>
                    `;
                });
                document.getElementById('storesLocationLegend').innerHTML = legendHTML;
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
                    type: 'pie',
                    data: {
                        labels: ['Approved', 'Pending', 'Rejected'],
                        datasets: [{
                            data: [data.approved, data.pending, data.rejected],
                            backgroundColor: [
                                '#6B4226',
                                '#F4D06F',
                                '#D5CDC2'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
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
    loadStoresLocationChart();
    loadSellersChart();
    loadReviewStats();
</script>
@endsection