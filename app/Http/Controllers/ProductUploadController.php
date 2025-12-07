<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductUploadController extends Controller
{
    /**
     * SRS-MartPlace-03: Show product upload form
     */
    public function showUploadForm()
    {
        // Check if user is seller
        $user = Auth::user();
        if (!$user || $user->role !== 'penjual') {
            return redirect('/login')->with('error', 'Anda harus login sebagai penjual untuk mengakses halaman ini.');
        }

        $seller = Seller::where('id', $user->seller_id)->first();
        if (!$seller || $seller->status !== 'approved') {
            return redirect('/login')->with('error', 'Akun penjual Anda belum disetujui.');
        }

        // Get all categories
        $categories = ProductCategory::orderBy('name')->get();
        
        return view('seller.products.upload', compact('categories', 'seller'));
    }

    /**
     * SRS-MartPlace-03: Handle product upload dengan field bahasa Indonesia
     */
    public function uploadProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Basic Product Info
            'name' => 'required|string|max:200',
            'description' => 'required|string|min:50',
            'category_id' => 'required|exists:product_categories,id',
            
            // Pricing & Stock
            'price' => 'required|numeric|min:100',
            'stock' => 'required|integer|min:1',
            'berat' => 'required|numeric|min:0.1', // Ganti dari weight ke berat
            
            // Condition & Location
            'kondisi' => 'required|in:baru,bekas', // Ganti dari condition ke kondisi
            'location_province' => 'required|string|max:100',
            'location_city' => 'required|string|max:100',
            
            // Product Images
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            
            // Additional fields dengan nama Indonesia
            'merek' => 'nullable|string|max:100',
            'garansi' => 'nullable|string|max:200',
            'dimensi_panjang' => 'nullable|numeric|min:0',
            'dimensi_lebar' => 'nullable|numeric|min:0',
            'dimensi_tinggi' => 'nullable|numeric|min:0',
            'bahan' => 'nullable|string|max:100',
            'spesifikasi' => 'nullable|array',
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'description.min' => 'Deskripsi produk minimal 50 karakter',
            'price.min' => 'Harga minimal Rp 100',
            'stock.min' => 'Stok minimal 1 buah',
            'berat.required' => 'Berat produk wajib diisi',
            'kondisi.required' => 'Kondisi produk wajib dipilih',
            'images.required' => 'Minimal 1 gambar produk harus diupload',
            'images.max' => 'Maksimal 5 gambar produk',
            'images.*.image' => 'File harus berupa gambar',
            'images.*.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $seller = Seller::where('id', $user->seller_id)->first();

        // Prepare dimensi data
        $dimensi = null;
        if ($request->dimensi_panjang || $request->dimensi_lebar || $request->dimensi_tinggi) {
            $dimensi = [
                'panjang' => $request->dimensi_panjang ?? 0,
                'lebar' => $request->dimensi_lebar ?? 0,
                'tinggi' => $request->dimensi_tinggi ?? 0,
                'unit' => 'cm'
            ];
        }

        // Prepare spesifikasi data
        $spesifikasi = [];
        if ($request->has('spesifikasi')) {
            foreach ($request->spesifikasi as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $spesifikasi[$spec['key']] = $spec['value'];
                }
            }
        }

        // Create product
        $product = Product::create([
            'seller_id' => $seller->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'berat' => $request->berat,
            'kondisi' => $request->kondisi,
            'location_province' => $request->location_province,
            'location_city' => $request->location_city,
            'sold_count' => 0,
            'average_rating' => 0,
            // Field tambahan dengan nama Indonesia
            'merek' => $request->merek,
            'garansi' => $request->garansi,
            'dimensi' => $dimensi,
            'bahan' => $request->bahan,
            'spesifikasi' => $spesifikasi,
        ]);

        // Upload and save product images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products/' . $product->id, 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_main' => $index === 0, // First image is main image
                ]);
            }
        }

        return redirect('/seller/products')->with('success', 
            'Produk berhasil diupload! Produk Anda akan ditinjau dalam 1-2 hari kerja.');
    }

    /**
     * Show seller's products
     */
    public function showSellerProducts()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'penjual') {
            return redirect('/login');
        }

        $seller = Seller::where('id', $user->seller_id)->first();
        $products = Product::where('seller_id', $seller->id)
            ->with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('seller.products', compact('products', 'seller'));
    }
}
