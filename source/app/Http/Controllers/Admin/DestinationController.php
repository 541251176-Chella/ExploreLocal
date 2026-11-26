<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::with('category')->withAvg('reviews', 'rating')->withCount('reviews');

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->query('category')) {
            $query->where('category_id', $categoryId);
        }

        return view('admin.destinations.index', [
            'destinations' => $query->latest()->paginate(10)->withQueryString(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.destinations.create', [
            'destination' => new Destination(['ticket_price' => 0]),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['image'] = $this->resolveImage($request);

        $destination = Destination::create($data);

        return redirect()->route('admin.destinations.index')
            ->with('success', "Destinasi \"{$destination->name}\" berhasil ditambahkan.");
    }

    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', [
            'destination' => $destination,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Destination $destination)
    {
        $data = $this->validated($request);

        if ($data['name'] !== $destination->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $destination->id);
        }

        if ($newImage = $this->resolveImage($request)) {
            $destination->deleteStoredImage();
            $data['image'] = $newImage;
        }

        $destination->update($data);

        return redirect()->route('admin.destinations.index')
            ->with('success', "Destinasi \"{$destination->name}\" berhasil diperbarui.");
    }

    public function destroy(Destination $destination)
    {
        $destination->deleteStoredImage();
        $name = $destination->name;
        $destination->delete();

        return redirect()->route('admin.destinations.index')
            ->with('success', "Destinasi \"{$name}\" dihapus.");
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'ticket_price' => ['nullable', 'integer', 'min:0'],
            'open_hours' => ['nullable', 'string', 'max:100'],
            'facilities' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'image_url' => ['nullable', 'url', 'max:500'],
        ]);

        $data['ticket_price'] = $data['ticket_price'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');

        unset($data['image'], $data['image_url']);

        return $data;
    }

    /** Prioritas: file upload, lalu link URL. Kalau dua-duanya kosong -> null (foto lama dipertahankan). */
    private function resolveImage(Request $request): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('destinations', 'public');
        }

        return $request->filled('image_url') ? $request->input('image_url') : null;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'destinasi';
        $slug = $base;
        $i = 2;

        while (Destination::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
