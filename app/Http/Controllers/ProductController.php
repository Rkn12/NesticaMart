<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Seller;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * SRS-MartPlace-03: Upload produk oleh penjual
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:sellers,id',
            'category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:200',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|integer|min:0',
            'condition' => 'required|in:new,used',
            'location_province' => 'required|string|max:100',
            'location_city' => 'required|string|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah seller sudah approved
        $seller = Seller::findOrFail($request->seller_id);
        if ($seller->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya penjual yang sudah diverifikasi yang dapat menambah produk.'
            ], 403);
        }

        $product = Product::create($request->except('images'));

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $product->images()->create([
                    'image_url' => $path,
                    'is_primary' => $product->images()->count() === 0, // First image is primary
                ]);
            }
        }

        // Log stock awal
        StockLog::create([
            'product_id' => $product->id,
            'change_type' => 'initial',
            'quantity_change' => $request->stock,
            'stock_before' => 0,
            'stock_after' => $request->stock,
            'notes' => 'Stok awal produk',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan.',
            'data' => $product->load('images')
        ], 201);
    }

    /**
     * SRS-MartPlace-04: Katalog produk dengan komentar dan rating
     * SRS-MartPlace-05: Pencarian produk
     */
    public function index(Request $request)
    {
        $query = Product::with(['seller', 'category', 'reviews'])
            // hanya tampilkan produk dari seller yang sudah approved
            ->whereHas('seller', function($q) {
                $q->where('status', 'approved');
            });

        // SRS-MartPlace-05: Pencarian fleksibel
        // Jika ada filter nama toko spesifik
        if ($request->filled('store_name')) {
            $store = $request->store_name;
            $query->whereHas('seller', function($q) use ($store) {
                $q->where('store_name', 'like', "%{$store}%");
            });
        }

        // Filter berdasarkan kategori pilihan
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Pencarian umum: coba cocokkan dengan nama produk, nama kategori, nama toko, atau lokasi toko
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhereHas('category', function($q2) use ($term) {
                      $q2->where('name', 'like', "%{$term}%");
                  })
                  ->orWhereHas('seller', function($q3) use ($term) {
                      $q3->where('store_name', 'like', "%{$term}%")
                         ->orWhere('province', 'like', "%{$term}%")
                         ->orWhere('city', 'like', "%{$term}%");
                  });
            });
        }

        // Pencarian berdasarkan lokasi spesifik (prioritas filter)
        if ($request->filled('province')) {
            $province = $request->province;
            // coba cocokkan produk location atau toko yang berlokasi di province tersebut
            $query->where(function($q) use ($province) {
                $q->where('location_province', 'like', "%{$province}%")
                  ->orWhereHas('seller', function($q2) use ($province) {
                      $q2->where('province', 'like', "%{$province}%");
                  });
            });
        }

        if ($request->filled('city')) {
            $city = $request->city;
            $query->where(function($q) use ($city) {
                $q->where('location_city', 'like', "%{$city}%")
                  ->orWhereHas('seller', function($q2) use ($city) {
                      $q2->where('city', 'like', "%{$city}%");
                  });
            });
        }

        // Filter by condition
        if ($request->has('condition')) {
            $query->where('condition', $request->condition);
        }

        // Sort by rating
        if ($request->has('sort_by_rating')) {
            $query->orderBy('average_rating', $request->sort_by_rating === 'asc' ? 'asc' : 'desc');
        }

        // Sort by price
        if ($request->has('sort_by_price')) {
            $query->orderBy('price', $request->sort_by_price === 'asc' ? 'asc' : 'desc');
        }

        $products = $query->paginate($request->get('per_page', 20))->appends($request->except('page'));
        $categories = ProductCategory::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * SRS-MartPlace-04: Detail produk dengan komentar dan rating
     */
    public function show($id)
    {
        $product = Product::with([
            'seller',
            'category',
            'images',
            'reviews' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Halaman form review produk
     */
    public function reviewForm($id)
    {
        $product = Product::with('seller')->findOrFail($id);
        return view('products.review', compact('product'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_id' => 'sometimes|exists:product_categories,id',
            'name' => 'sometimes|string|max:200',
            'description' => 'sometimes|string',
            'price' => 'sometimes|integer|min:0',
            'stock' => 'sometimes|integer|min:0',
            'weight' => 'nullable|integer|min:0',
            'condition' => 'sometimes|in:new,used',
            'location_province' => 'sometimes|string|max:100',
            'location_city' => 'sometimes|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Jika ada perubahan stock, catat log
        if ($request->has('stock') && $request->stock != $product->stock) {
            $stockBefore = $product->stock;
            $stockAfter = $request->stock;
            $change = $stockAfter - $stockBefore;

            StockLog::create([
                'product_id' => $product->id,
                'change_type' => $change > 0 ? 'addition' : 'reduction',
                'quantity_change' => abs($change),
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'notes' => $request->get('stock_notes', 'Update manual stok produk'),
            ]);
        }

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diupdate.',
            'data' => $product
        ]);
    }

    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus.'
        ]);
    }

    /**
     * Get produk berdasarkan seller
     */
    public function getBySellerDashboard($seller_id)
    {
        $products = Product::where('seller_id', $seller_id)
            ->with(['category', 'reviews'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Get kategori produk
     */
    public function getCategories()
    {
        $categories = ProductCategory::withCount('products')->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
