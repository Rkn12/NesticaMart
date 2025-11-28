<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller
{
    /**
     * Tampilkan semua review
     */
    public function index()
    {
        $reviews = ProductReview::with(['product.seller'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * SRS-MartPlace-06: Pemberian komentar dan rating pada produk
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'reviewer_name' => 'required|string|max:150',
            'reviewer_phone' => 'required|string|max:20',
            'reviewer_email' => 'required|email|max:150',
            'reviewer_province' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:20480',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['photos', 'video']);

        // Upload foto
        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('review_photos', 'public');
                $photoPaths[] = $path;
            }
            $data['photos'] = json_encode($photoPaths);
        }

        // Upload video
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('review_videos', 'public');
        }

        // Simpan review
        $review = ProductReview::create($data);

        // Update average rating produk
        $product = Product::with('seller')->findOrFail($request->product_id);
        $averageRating = $product->reviews()->avg('rating');
        $product->update(['average_rating' => round($averageRating, 2)]);

        // SRS-MartPlace-06: Kirim notifikasi email ke penjual
        $this->sendReviewNotificationEmail($product, $review);

        // Kirim konfirmasi/ucapan terima kasih ke reviewer (email yang diisi saat review)
        $this->sendReviewerConfirmationEmail($product, $review);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review berhasil ditambahkan. Terima kasih atas feedback Anda!',
                'data' => $review
            ]);
        }

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Review berhasil ditambahkan. Terima kasih atas feedback Anda!');
    }

    /**
     * Kirim email notifikasi review ke penjual
     */
    private function sendReviewNotificationEmail($product, $review)
    {
        $seller = $product->seller;
        $subject = "Produk Anda Mendapat Review Baru - {$product->name}";
        
        $message = "Halo {$seller->owner_name},\n\n";
        $message .= "Produk '{$product->name}' Anda telah mendapatkan review baru.\n\n";
        $message .= "Rating: {$review->rating}/5\n";
        $message .= "Reviewer: {$review->reviewer_name}\n";
        $message .= "Email: {$review->reviewer_email}\n";
        
        if ($review->comment) {
            $message .= "Komentar: {$review->comment}\n";
        }
        
        $message .= "\nRating rata-rata produk sekarang: {$product->average_rating}/5\n";

        Mail::raw($message, function ($mail) use ($seller, $subject) {
            $mail->to($seller->email)
                ->subject($subject);
        });
    }

    /**
     * Kirim email konfirmasi/terima kasih ke reviewer (email yang dimasukkan saat review)
     */
    private function sendReviewerConfirmationEmail($product, $review)
    {
        $subject = "Terima kasih atas review Anda untuk {$product->name}";

        $message = "Halo {$review->reviewer_name},\n\nTerima kasih telah memberikan rating untuk produk '{$product->name}'.\n\nRating yang Anda berikan: {$review->rating}/5\n";

        if ($review->comment) {
            $message .= "Komentar Anda: {$review->comment}\n\n";
        }

        $message .= "Anda dapat melihat produk di: " . url("/products/{$product->id}") . "\n\nTerima kasih,\nTim Marketplace";

        Mail::raw($message, function ($mail) use ($review, $subject) {
            $mail->to($review->reviewer_email)
                ->subject($subject);
        });
    }

    /**
     * Get review berdasarkan produk
     */
    public function getByProduct($product_id)
    {
        $reviews = ProductReview::where('product_id', $product_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }

    /**
     * Get statistik rating produk
     */
    public function getRatingStats($product_id)
    {
        $product = Product::findOrFail($product_id);
        
        $stats = [
            'average_rating' => $product->average_rating,
            'total_reviews' => $product->reviews()->count(),
            'rating_distribution' => [
                5 => $product->reviews()->where('rating', 5)->count(),
                4 => $product->reviews()->where('rating', 4)->count(),
                3 => $product->reviews()->where('rating', 3)->count(),
                2 => $product->reviews()->where('rating', 2)->count(),
                1 => $product->reviews()->where('rating', 1)->count(),
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Update review (opsional)
     */
    public function update(Request $request, $id)
    {
        $review = ProductReview::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $review->update($request->only(['rating', 'comment']));

        // Update average rating produk
        $product = $review->product;
        $averageRating = $product->reviews()->avg('rating');
        $product->update(['average_rating' => round($averageRating, 2)]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil diupdate.',
            'data' => $review
        ]);
    }

    /**
     * Hapus review
     */
    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        $product = $review->product;
        
        $review->delete();

        // Update average rating produk
        $averageRating = $product->reviews()->avg('rating') ?? 0;
        $product->update(['average_rating' => round($averageRating, 2)]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil dihapus.'
        ]);
    }
}
