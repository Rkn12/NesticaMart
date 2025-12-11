@extends('layouts.app')

@section('title', 'Product Reviews - Nestica')

@section('content')
<style>
    .reviews-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .page-title {
        font-size: 28px;
        color: #483A2E;
        font-weight: bold;
        margin-bottom: 30px;
    }
    
    .review-card {
        background: #ffffff;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .product-name {
        font-size: 20px;
        font-weight: bold;
        color: #483A2E;
        margin: 0;
    }
    
    .review-date {
        color: #999;
        font-size: 13px;
    }
    
    .stars {
        font-size: 20px;
        color: #EFCD77;
        margin-bottom: 10px;
    }
    
    .stars .empty {
        color: #D5CDC2;
    }
    
        .review-title {
            font-size: 16px;
            font-weight: 600;
            color: #483A2E;
            margin: 10px 0 5px 0;
        }

        .reviewer-contact {
            font-size: 12px;
            color: #999;
            margin-bottom: 10px;
        }    .review-comment {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        margin: 10px 0 15px 0;
    }
    
    .review-comment.no-comment {
        color: #999;
        font-style: italic;
    }
    
    .reviewer-info {
        font-size: 14px;
        color: #7E991E;
        font-weight: 600;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #FBFDF0;
        border-radius: 15px;
    }
    
    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }
    
    .empty-state h4 {
        color: #483A2E;
        font-size: 20px;
        margin-bottom: 10px;
    }
    
    .empty-state p {
        color: #999;
        font-size: 14px;
    }
    
    .pagination {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    
    .page-link {
        padding: 10px 18px;
        background: white;
        color: #483A2E;
        border: 2px solid #D5CDC2;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .page-link:hover {
        background: #7E991E;
        color: white;
        border-color: #7E991E;
    }
    
    .page-link.active {
        background: #483A2E;
        color: white;
        border-color: #483A2E;
    }
    
    .page-link.disabled {
        background: #f0f0f0;
        color: #999;
        border-color: #e0e0e0;
        cursor: not-allowed;
    }
</style>

<div class="reviews-container">
    <h1 class="page-title">Product Reviews</h1>
    
    @forelse($reviews as $review)
        <div class="review-card">
            <div class="review-header">
                <h2 class="product-name">{{ $review->product->name }}</h2>
                <span class="review-date">{{ $review->created_at->format('d F Y') }}</span>
            </div>
            
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $review->rating)
                        ★
                    @else
                        <span class="empty">★</span>
                    @endif
                @endfor
            </div>
            
            <h3 class="review-title">{{ $review->reviewer_name }}</h3>
            
            <div class="reviewer-contact">
                {{ $review->reviewer_phone }} | {{ $review->reviewer_email }}
            </div>
            
            @if($review->comment)
                <p class="review-comment">{{ $review->comment }}</p>
            @else
                <p class="review-comment no-comment">No comment provided</p>
            @endif
            
            <div class="reviewer-info">
                {{ $review->reviewer_province }}
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon">📝</div>
            <h4>No Reviews Yet</h4>
            <p>There are no customer reviews for products in the marketplace</p>
        </div>
    @endforelse
    
    @if($reviews->hasPages())
        <div class="pagination">
            @if ($reviews->onFirstPage())
                <span class="page-link disabled">‹ Previous</span>
            @else
                <a href="{{ $reviews->previousPageUrl() }}" class="page-link">‹ Previous</a>
            @endif
            
            @foreach(range(1, $reviews->lastPage()) as $page)
                @if($page == $reviews->currentPage())
                    <span class="page-link active">{{ $page }}</span>
                @else
                    <a href="{{ $reviews->url($page) }}" class="page-link">{{ $page }}</a>
                @endif
            @endforeach
            
            @if ($reviews->hasMorePages())
                <a href="{{ $reviews->nextPageUrl() }}" class="page-link">Next ›</a>
            @else
                <span class="page-link disabled">Next ›</span>
            @endif
        </div>
    @endif
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
