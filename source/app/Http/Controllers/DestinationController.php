<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::with('category')->withAvg('reviews', 'rating')->withCount('reviews');

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->query('category')) {
            $query->where('category_id', $categoryId);
        }

        match ($request->query('sort')) {
            'populer' => $query->orderByDesc('views'),
            'rating' => $query->orderByDesc('reviews_avg_rating'),
            'termurah' => $query->orderBy('ticket_price'),
            default => $query->latest(),
        };

        return view('destinations.index', [
            'destinations' => $query->paginate(9)->withQueryString(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function show(Destination $destination)
    {
        $destination->increment('views');
        $destination->load('category');
        $destination->loadAvg('reviews', 'rating')->loadCount('reviews');

        $reviews = $destination->reviews()->with('user')->latest()->get();

        $related = Destination::with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('category_id', $destination->category_id)
            ->where('id', '!=', $destination->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        $myReview = auth()->check() ? $reviews->firstWhere('user_id', auth()->id()) : null;

        return view('destinations.show', compact('destination', 'reviews', 'related', 'myReview'));
    }
}
