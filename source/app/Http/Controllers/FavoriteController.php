<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $destinations = $request->user()->favorites()
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest('favorites.created_at')
            ->paginate(9);

        return view('favorites.index', compact('destinations'));
    }

    public function toggle(Request $request, Destination $destination)
    {
        $result = $request->user()->favorites()->toggle($destination->id);
        $added = count($result['attached']) > 0;

        return back()->with('success', $added
            ? $destination->name . ' ditambahkan ke favorit.'
            : $destination->name . ' dihapus dari favorit.');
    }
}
