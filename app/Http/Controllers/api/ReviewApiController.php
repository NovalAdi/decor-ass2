<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewApiController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'produk'])->get();

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }

    // POST /api/reviews
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => ['required', 'exists:produks,id'],
            'user_id'   => ['required', 'exists:users,id'],
            'review'    => ['nullable', 'string'],
            'rating'    => ['required', 'numeric', 'between:0,5'],
        ]);

        $review = Review::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil ditambahkan',
            'data' => $review
        ], 201);
    }

    // GET /api/reviews/{id}
    public function show($id)
    {
        $review = Review::with(['user', 'produk'])->find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $review
        ]);
    }

    // PUT /api/reviews/{id}
    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'review' => ['nullable', 'string'],
            'rating' => ['nullable', 'numeric', 'between:0,5'],
        ]);

        $review->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil diperbarui',
            'data' => $review
        ]);
    }

    // DELETE /api/reviews/{id}
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review tidak ditemukan'
            ], 404);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil dihapus'
        ]);
    }
}
