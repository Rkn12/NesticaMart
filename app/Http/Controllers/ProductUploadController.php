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
            
            // Product Images
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'description.min' => 'Deskripsi produk minimal 50 karakter',
            'price.min' => 'Harga minimal Rp 100',
            'stock.min' => 'Stok minimal 1 buah',
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

        // Create product
        $product = Product::create([
            'seller_id' => $seller->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'berat' => 1.0, // Default weight as fallback
            'kondisi' => 'baru', // Default new condition
            'location_province' => $seller->province ?? 'Unknown',
            'location_city' => $seller->city ?? 'Unknown',
            'sold_count' => 0,
            'average_rating' => 0,
        ]);

        // Upload and save product images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products/' . $product->id, 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 
            'Produk berhasil diupload!');
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
