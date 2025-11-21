@extends('layouts.app')

@section('title', 'All Reviews')
@section('page-title', 'Semua Review')

@section('content')
    <div class="card">
        <h3 style="margin-bottom: 20px;">Daftar Semua Review</h3>
        
        @forelse($reviews as $review)
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #667eea;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <h4 style="margin: 0 0 5px 0; color: #333;">
                            <a href="{{ route('products.show', $review->product->id) }}" style="color: #667eea; text-decoration: none;">
                                {{ $review->product->name }}
                            </a>
                        </h4>
                        <p style="color: #999; font-size: 14px; margin: 0;">
                            {{ $review->product->seller->store_name ?? 'Unknown' }}
                        </p>
                    </div>
                    <div style="text-align: right;">
                        <span style="color: #f39c12; font-size: 18px;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    ⭐
                                @else
                                    ☆
                                @endif
                            @endfor
                        </span>
                        <p style="color: #999; font-size: 12px; margin: 5px 0 0 0;">
                            {{ $review->rating }}/5
                        </p>
                    </div>
                </div>

                <div style="border-top: 1px solid #ddd; padding-top: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <strong style="color: #333;">{{ $review->reviewer_name }}</strong>
                        <span style="color: #999; font-size: 13px;">
                            {{ $review->created_at->locale('id')->diffForHumans() }}
                        </span>
                    </div>
                    
                    @if($review->comment)
                        <p style="color: #555; font-size: 14px; line-height: 1.6; margin: 10px 0;">
                            "{{ $review->comment }}"
                        </p>
                    @else
                        <p style="color: #999; font-style: italic; font-size: 14px;">
                            Tidak ada komentar
                        </p>
                    @endif

                    <div style="margin-top: 10px; font-size: 13px; color: #666;">
                        <span>📧 {{ $review->reviewer_email }}</span>
                        <span style="margin-left: 15px;">📱 {{ $review->reviewer_phone }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 60px 20px; color: #999;">
                <div style="font-size: 48px; margin-bottom: 15px;">📝</div>
                <h4 style="color: #666; margin-bottom: 10px;">Belum Ada Review</h4>
                <p>Belum ada review dari customer untuk produk-produk di marketplace</p>
            </div>
        @endforelse

        @if($reviews->hasPages())
            <div style="margin-top: 30px; display: flex; justify-content: center; gap: 10px;">
                @if ($reviews->onFirstPage())
                    <span style="padding: 10px 15px; background: #e0e0e0; color: #999; border-radius: 8px; cursor: not-allowed;">‹ Prev</span>
                @else
                    <a href="{{ $reviews->previousPageUrl() }}" style="padding: 10px 15px; background: white; color: #667eea; border: 2px solid #667eea; border-radius: 8px; text-decoration: none; font-weight: 500;">‹ Prev</a>
                @endif

                @foreach(range(1, $reviews->lastPage()) as $page)
                    @if($page == $reviews->currentPage())
                        <span style="padding: 10px 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; font-weight: 500;">{{ $page }}</span>
                    @else
                        <a href="{{ $reviews->url($page) }}" style="padding: 10px 15px; background: white; color: #667eea; border: 2px solid #e0e0e0; border-radius: 8px; text-decoration: none; font-weight: 500;">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($reviews->hasMorePages())
                    <a href="{{ $reviews->nextPageUrl() }}" style="padding: 10px 15px; background: white; color: #667eea; border: 2px solid #667eea; border-radius: 8px; text-decoration: none; font-weight: 500;">Next ›</a>
                @else
                    <span style="padding: 10px 15px; background: #e0e0e0; color: #999; border-radius: 8px; cursor: not-allowed;">Next ›</span>
                @endif
            </div>
        @endif
    </div>
@endsection
