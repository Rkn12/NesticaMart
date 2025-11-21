@extends('layouts.app')

@section('title', 'Katalog Produk')
@section('page-title', 'Katalog Produk')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Katalog Produk</h3>
        </div>
        
        <div class="search-bar">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari produk...">
            <select id="categoryFilter" class="form-control" style="max-width: 200px;">
                <option value="">Semua Kategori</option>
            </select>
            <input type="text" id="provinceFilter" class="form-control" placeholder="Provinsi" style="max-width: 150px;">
            <button class="btn btn-primary" onclick="loadProducts()">Cari</button>
        </div>
        
        <div id="productsGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
            <div style="text-align: center; padding: 40px; grid-column: 1/-1;">
                <p>Loading...</p>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
<script>
    async function loadCategories() {
        try {
            const response = await fetch('/products/categories', {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();
            
            if (result.success) {
                const select = document.getElementById('categoryFilter');
                result.data.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id;
                    option.textContent = cat.name;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    async function loadProducts() {
        const search = document.getElementById('searchInput').value;
        const category = document.getElementById('categoryFilter').value;
        const province = document.getElementById('provinceFilter').value;
        
        let url = '/products?';
        if (search) url += `search=${encodeURIComponent(search)}&`;
        if (category) url += `category_id=${category}&`;
        if (province) url += `province=${encodeURIComponent(province)}&`;
        
        try {
            const response = await fetch(url, {
                headers: {'Accept': 'application/json'}
            });
            const result = await response.json();
            
            if (result.success) {
                displayProducts(result.data.data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    function displayProducts(products) {
        const gridHTML = products.map(product => `
            <div style="background: white; border: 1px solid #eee; border-radius: 10px; padding: 20px; cursor: pointer;" onclick="window.location.href='/products/${product.id}'">
                <div style="height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 5px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                    📦
                </div>
                <h4 style="margin-bottom: 10px; color: #333; font-size: 16px; height: 40px; overflow: hidden;">${product.name}</h4>
                <p style="color: #667eea; font-size: 18px; font-weight: bold; margin-bottom: 5px;">Rp ${product.price.toLocaleString('id-ID')}</p>
                <p style="color: #999; font-size: 13px; margin-bottom: 10px;">${product.seller?.store_name || 'Unknown'}</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                    <span style="color: #f39c12;">⭐ ${product.average_rating || 0}</span>
                    <span style="color: ${product.stock > 10 ? '#27ae60' : product.stock > 0 ? '#f39c12' : '#e74c3c'}; font-size: 12px;">
                        Stok: ${product.stock}
                    </span>
                </div>
            </div>
        `).join('');
        
        document.getElementById('productsGrid').innerHTML = gridHTML || '<p style="text-align: center; grid-column: 1/-1;">Tidak ada produk</p>';
    }
    
    loadCategories();
    loadProducts();
</script>
@endsection
