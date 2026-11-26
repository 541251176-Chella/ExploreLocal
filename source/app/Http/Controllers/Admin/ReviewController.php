<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.reviews.index', [
            'reviews' => Review::with(['user', 'destination'])->latest()->paginate(10),
        ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Ulasan dihapus.');
    }
}
