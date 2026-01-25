<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $guarded = [];

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
}
