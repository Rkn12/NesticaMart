@extends('layouts.app')

@section('title', 'All Reviews')
@section('page-title', 'Semua Review')

@section('content')
    <div class="card">
        <h3 style="margin-bottom: 20px;">Daftar Semua Review</h3>
        
        <div id="reviewsList">
            <div style="text-align: center; padding: 40px;">
                <p>Loading...</p>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
<script>
    async function loadAllReviews() {
        try {
            const response = await fetch('/products', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();
            
            if (result.success) {
                displayReviews(result.data.data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    function displayReviews(products) {
        const reviewsHTML = products.filter(p => p.reviews && p.reviews.length > 0)
            .map(product => `
                <div style="margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 20px;">
                    <h4 style="margin-bottom: 10px;">
                        <a href="/products/${product.id}" style="color: #667eea; text-decoration: none;">
                            ${product.name}
                        </a>
                    </h4>
                    <p style="color: #999; font-size: 14px; margin-bottom: 15px;">
                        ${product.seller?.store_name || 'Unknown'} • ⭐ ${product.average_rating || 0}/5
                    </p>
                    
                    ${product.reviews.slice(0, 3).map(review => `
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 10px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <strong>${review.reviewer_name}</strong>
                                <span style="color: #f39c12;">${'⭐'.repeat(review.rating)}</span>
                            </div>
                            <p style="color: #555; font-size: 14px;">${review.comment || 'Tidak ada komentar'}</p>
                            <p style="color: #999; font-size: 12px; margin-top: 5px;">
                                ${new Date(review.created_at).toLocaleDateString('id-ID')}
                            </p>
                        </div>
                    `).join('')}
                    
                    ${product.reviews.length > 3 ? `
                        <a href="/products/${product.id}" class="btn btn-sm btn-primary" style="margin-top: 10px;">
                            Lihat semua ${product.reviews.length} review
                        </a>
                    ` : ''}
                </div>
            `).join('');
        
        document.getElementById('reviewsList').innerHTML = reviewsHTML || '<p>Belum ada review</p>';
    }
    
    loadAllReviews();
</script>
@endsection
