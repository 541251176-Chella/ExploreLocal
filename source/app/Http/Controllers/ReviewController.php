<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Destination $destination)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        Review::updateOrCreate(
            ['user_id' => $request->user()->id, 'destination_id' => $destination->id],
            $data
        );

        return redirect()->to(route('destinations.show', $destination) . '#ulasan')
            ->with('success', 'Terima kasih, ulasanmu sudah tersimpan!');
    }

    public function destroy(Request $request, Review $review)
    {
        abort_unless($request->user()->isAdmin() || $review->user_id === $request->user()->id, 403);

        $slug = $review->destination->slug;
        $review->delete();

        return redirect()->to(route('destinations.show', $slug) . '#ulasan')
            ->with('success', 'Ulasan dihapus.');
    }
}
