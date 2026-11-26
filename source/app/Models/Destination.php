<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Destination extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'city', 'province', 'address', 'description',
        'ticket_price', 'open_hours', 'facilities', 'image', 'latitude', 'longitude',
        'is_featured', 'views',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'ticket_price' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /** URL foto: bisa link eksternal, file upload, atau placeholder. */
    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('images/placeholder.svg');
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function getTicketLabelAttribute(): string
    {
        return $this->ticket_price > 0
            ? 'Rp ' . number_format($this->ticket_price, 0, ',', '.')
            : 'Gratis';
    }

    public function getLocationLabelAttribute(): string
    {
        return $this->city . ', ' . $this->province;
    }

    public function getFacilityListAttribute(): array
    {
        return collect(preg_split('/[\r\n,]+/', (string) $this->facilities))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    public function getMapEmbedUrlAttribute(): ?string
    {
        if ($this->latitude === null || $this->longitude === null) {
            return null;
        }

        return 'https://maps.google.com/maps?q=' . $this->latitude . ',' . $this->longitude . '&z=12&output=embed';
    }

    /** Hapus file foto dari storage (hanya kalau berupa upload, bukan URL). */
    public function deleteStoredImage(): void
    {
        if ($this->image && ! Str::startsWith($this->image, ['http://', 'https://'])) {
            Storage::disk('public')->delete($this->image);
        }
    }
}
