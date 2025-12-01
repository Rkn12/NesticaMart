@extends('layouts.app')

@section('title', 'Katalog Produk')
@section('page-title', 'Katalog Produk')

@section('content')
    <div class="card">
        
        <form method="GET" action="{{ route('products.index') }}" class="search-bar" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; margin-bottom: 20px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
            
            <input type="text" name="store_name" class="form-control" placeholder="Nama toko..." value="{{ request('store_name') }}">
            
            <select name="category_id" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            
            <select name="province" id="province" class="form-control select2">
                <option value="">Semua Provinsi</option>
            </select>
            
            <select name="city" id="city" class="form-control select2" disabled>
                <option value="">Semua Kota/Kabupaten</option>
            </select>
            
            <button type="submit" class="btn btn-primary" style="grid-column: span 1;">🔍 Cari</button>
        </form>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
            @forelse($products as $product)
                <div style="background: white; border: 1px solid #eee; border-radius: 10px; padding: 20px; cursor: pointer;" onclick="window.location.href='{{ route('products.show', $product->id) }}'">
                    <div style="height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 5px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                        📦
                    </div>
                    <h4 style="margin-bottom: 10px; color: #333; font-size: 16px; height: 40px; overflow: hidden;">{{ $product->name }}</h4>
                    <p style="color: #667eea; font-size: 18px; font-weight: bold; margin-bottom: 5px;">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p style="color: #999; font-size: 13px; margin-bottom: 10px;">{{ $product->seller->store_name ?? 'Unknown' }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <span style="color: #f39c12;">⭐ {{ number_format($product->average_rating ?? 0, 1) }}</span>
                    </div>
                </div>
            @empty
                <p style="text-align: center; grid-column: 1/-1; padding: 40px; color: #999;">Tidak ada produk ditemukan</p>
            @endforelse
        </div>

        @if($products->hasPages())
            <div style="margin-top: 30px; display: flex; justify-content: center; gap: 10px;">
                @if ($products->onFirstPage())
                    <span style="padding: 10px 15px; background: #e0e0e0; color: #999; border-radius: 8px; cursor: not-allowed;">‹ Prev</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" style="padding: 10px 15px; background: white; color: #667eea; border: 2px solid #667eea; border-radius: 8px; text-decoration: none; font-weight: 500;">‹ Prev</a>
                @endif

                @foreach(range(1, $products->lastPage()) as $page)
                    @if($page == $products->currentPage())
                        <span style="padding: 10px 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; font-weight: 500;">{{ $page }}</span>
                    @else
                        <a href="{{ $products->url($page) }}" style="padding: 10px 15px; background: white; color: #667eea; border: 2px solid #e0e0e0; border-radius: 8px; text-decoration: none; font-weight: 500;">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" style="padding: 10px 15px; background: white; color: #667eea; border: 2px solid #667eea; border-radius: 8px; text-decoration: none; font-weight: 500;">Next ›</a>
                @else
                    <span style="padding: 10px 15px; background: #e0e0e0; color: #999; border-radius: 8px; cursor: not-allowed;">Next ›</span>
                @endif
            </div>
        @endif
    </div>
@endsection

@section('extra-scripts')
<script>
$(document).ready(function() {
    $('.select2').select2();

    var selectedProvince = "{{ request('province') }}";
    var selectedCity = "{{ request('city') }}";

    // Load Provinces
    $.get('/api/regions/provinces', function(data) {
        var provinceSelect = $('#province');
        $.each(data, function(index, province) {
            var option = new Option(province.name, province.name);
            $(option).attr('data-code', province.code);
            if (province.name === selectedProvince) {
                $(option).prop('selected', true);
            }
            provinceSelect.append(option);
        });
        
        // Trigger change if province is selected to load cities
        if (selectedProvince) {
            // We need to wait for options to be appended? No, synchronous enough in loop.
            // But we need to find the code again because we just appended it.
            // Actually, we can just trigger change.
            // But wait, if we trigger change, it will fetch cities.
            // But we need to pass the code.
            // The change event handler gets code from :selected.
            // Since we set selected property, it should work.
            provinceSelect.trigger('change');
        }
    });

    $('#province').on('change', function() {
        var code = $(this).find(':selected').data('code');
        // If triggered programmatically, data('code') might not be available if select2 hasn't updated fully?
        // jQuery data() reads from data- attribute if not set via .data().
        // So attr('data-code') is safer to set.
        
        var citySelect = $('#city');
        
        citySelect.empty().append('<option value="">Semua Kota/Kabupaten</option>').prop('disabled', true);
        
        if (code) {
            $.get('/api/regions/regencies/' + code, function(data) {
                $.each(data, function(index, city) {
                    var option = new Option(city.name, city.name);
                    if (city.name === selectedCity) {
                        $(option).prop('selected', true);
                    }
                    citySelect.append(option);
                });
                citySelect.prop('disabled', false);
            });
        }
    });
});
</script>
@endsection
