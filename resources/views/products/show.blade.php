@extends('layouts.app')

@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')

@section('content')
    <div class="card">
        <a href="/products" class="btn btn-primary" style="width: fit-content; margin-bottom: 20px; padding: 12px 24px; font-size: 16px;">← Kembali</a>
        
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
            <div>
                <div style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 120px;">
                    📦
                </div>
            </div>
            <div>
                <h2 style="margin-bottom: 10px;">{{ $product->name }}</h2>
                <p style="color: #667eea; font-size: 32px; font-weight: bold; margin-bottom: 20px;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
                
                <div style="display: flex; gap: 20px; margin-bottom: 20px; align-items: center;">
                    <span class="badge badge-{{ $product->condition === 'new' ? 'success' : 'warning' }}">
                        {{ $product->condition === 'new' ? 'Baru' : 'Bekas' }}
                    </span>
                    <span style="color: #f39c12; font-size: 18px;">⭐ {{ number_format($product->average_rating ?? 0, 1) }}/5</span>
                    <span style="color: #666; font-weight: 500;">
                        @php
                            $sold = $product->sold_count ?? 0;
                            if ($sold >= 1000) {
                                $soldText = floor($sold / 1000) . 'rb+';
                            } else {
                                $soldText = $sold;
                            }
                        @endphp
                        🛒 {{ $soldText }} terjual
                    </span>
                    <span style="color: {{ $product->stock > 10 ? '#27ae60' : ($product->stock > 0 ? '#f39c12' : '#e74c3c') }}; font-weight: 500;">
                        Stok: {{ $product->stock }}
                    </span>
                </div>
                
                <h4 style="margin-top: 20px; margin-bottom: 10px; color: #333;">Deskripsi</h4>
                <p style="line-height: 1.6; color: #555;">{{ $product->description }}</p>
                
                <h4 style="margin-top: 20px; margin-bottom: 10px; color: #333;">Informasi Produk</h4>
                <table style="width: 100%; line-height: 2;">
                    <tr><td style="color: #666;"><strong>Kategori:</strong></td><td>{{ $product->category->name ?? '-' }}</td></tr>
                    <tr><td style="color: #666;"><strong>Berat:</strong></td><td>{{ $product->weight ?? '-' }} gram</td></tr>
                    <tr><td style="color: #666;"><strong>Kondisi:</strong></td><td>{{ $product->condition === 'new' ? 'Baru' : 'Bekas' }}</td></tr>
                    <tr><td style="color: #666;"><strong>Lokasi:</strong></td><td>{{ $product->location_city }}, {{ $product->location_province }}</td></tr>
                </table>
                
                <h4 style="margin-top: 20px; margin-bottom: 10px; color: #333;">Penjual</h4>
                <p><strong>{{ $product->seller->store_name ?? 'Unknown' }}</strong></p>
                <p style="color: #999; font-size: 14px;">{{ $product->seller->city ?? '' }}, {{ $product->seller->province ?? '' }}</p>
            </div>
        </div>
    </div>

    
    <div class="card" id="reviews">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0;">Review Produk ({{ $product->reviews->count() }})</h3>
            <a href="/products/{{ $product->id }}/review" style="padding: 10px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;">
                <span style="font-size: 18px;">⭐</span> Tulis Review
            </a>
        </div>
        
        @forelse($product->reviews as $review)
            <div style="border-bottom: 1px solid #eee; padding: 20px 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; align-items: center;">
                    <strong style="color: #333; font-size: 16px;">{{ $review->reviewer_name }}</strong>
                    <span style="color: #f39c12; font-size: 18px;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor
                    </span>
                </div>
                @if($review->comment)
                    <p style="color: #555; margin-bottom: 10px; line-height: 1.6;">"{{ $review->comment }}"</p>
                @else
                    <p style="color: #999; font-style: italic; margin-bottom: 10px;">Tidak ada komentar</p>
                @endif

                @if($review->photos || $review->video)
                    <div style="margin: 15px 0;">
                        @if($review->photos)
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; margin-bottom: 10px;">
                                @foreach($review->photos as $photo)
                                    <img src="{{ asset('storage/' . $photo) }}" alt="Review Photo" style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0; cursor: pointer;" onclick="window.open('{{ asset('storage/' . $photo) }}', '_blank')">
                                @endforeach
                            </div>
                        @endif

                        @if($review->video)
                            <video controls style="width: 100%; max-width: 400px; border-radius: 8px; border: 2px solid #e0e0e0;">
                                <source src="{{ asset('storage/' . $review->video) }}" type="video/mp4">
                                Browser Anda tidak support video tag.
                            </video>
                        @endif
                    </div>
                @endif

                <div style="color: #999; font-size: 13px; display: flex; gap: 15px;">
                    <span>📧 {{ $review->reviewer_email }}</span>
                    <span>📱 {{ $review->reviewer_phone }}</span>
                    <span>🕐 {{ $review->created_at->locale('id')->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <p style="text-align: center; color: #999; padding: 40px 0;">
                Belum ada review untuk produk ini. Jadilah yang pertama memberikan review!
            </p>
        @endforelse
    </div>
@endsection
