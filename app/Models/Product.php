<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_featured_home' => 'boolean',
    ];

    /**
     * Attributes to append to JSON (for API). Includes full image URL so
     * Flutter/mobile apps can load images without building the URL.
     */
    protected $appends = ['image_url'];

    /**
     * Full URL for the product image. Null when no image.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return Storage::disk('public')->url($this->image);
    }

    /**
     * stock: integer, available quantity in inventory
     */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product variants (same group_id)
    public function variants()
    {
        return $this->hasMany(Product::class, 'group_id', 'group_id')
            ->where('id', '!=', $this->id);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
