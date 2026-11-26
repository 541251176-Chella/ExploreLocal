<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Review;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $base = fn () => Destination::with('category')->withAvg('reviews', 'rating')->withCount('reviews');

        return view('home', [
            'featured' => $base()->where('is_featured', true)->latest()->take(6)->get(),
            'latest' => $base()->latest()->take(8)->get(),
            'categories' => Category::withCount('destinations')->orderBy('name')->get(),
            'stats' => [
                'destinations' => Destination::count(),
                'tourists' => User::where('role', 'tourist')->count(),
                'reviews' => Review::count(),
            ],
        ]);
    }
}
