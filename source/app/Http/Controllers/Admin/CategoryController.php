<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public const ICONS = [
        'fa-umbrella-beach' => 'Pantai',
        'fa-mountain' => 'Gunung',
        'fa-landmark' => 'Bangunan / Sejarah',
        'fa-water' => 'Air / Danau',
        'fa-ticket' => 'Wisata Keluarga',
        'fa-utensils' => 'Kuliner',
        'fa-tree' => 'Hutan / Taman',
        'fa-camera' => 'Spot Foto',
        'fa-campground' => 'Camping',
        'fa-person-hiking' => 'Hiking',
        'fa-location-dot' => 'Umum',
    ];

    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount('destinations')->orderBy('name')->get(),
            'icons' => self::ICONS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:categories,name'],
            'icon' => ['required', Rule::in(array_keys(self::ICONS))],
        ]);

        Category::create($data + ['slug' => $this->uniqueSlug($data['name'])]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'icons' => self::ICONS,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80', Rule::unique('categories', 'name')->ignore($category->id)],
            'icon' => ['required', Rule::in(array_keys(self::ICONS))],
        ]);

        if ($data['name'] !== $category->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $category->id);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->destinations()->exists()) {
            return back()->with('error', 'Kategori masih dipakai oleh destinasi. Pindahkan atau hapus destinasinya dulu.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'kategori';
        $slug = $base;
        $i = 2;

        while (Category::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
