<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $days = collect(range(13, 0))->map(fn ($i) => now()->subDays($i)->startOfDay());

        $categories = Category::withCount('destinations')->orderBy('name')->get();

        return view('admin.dashboard', [
            'stats' => [
                'destinations' => Destination::count(),
                'tourists' => User::where('role', 'tourist')->count(),
                'reviews' => Review::count(),
                'categories' => Category::count(),
            ],
            'chartLabels' => $days->map(fn ($d) => $d->format('d M'))->values()->all(),
            'chartUsers' => $days->map(fn ($d) => User::where('role', 'tourist')->whereDate('created_at', $d)->count())->values()->all(),
            'chartReviews' => $days->map(fn ($d) => Review::whereDate('created_at', $d)->count())->values()->all(),
            'categoryLabels' => $categories->pluck('name')->values()->all(),
            'categoryData' => $categories->pluck('destinations_count')->values()->all(),
            'topDestinations' => Destination::with('category')->orderByDesc('views')->take(5)->get(),
            'latestReviews' => Review::with(['user', 'destination'])->latest()->take(5)->get(),
        ]);
    }
}
