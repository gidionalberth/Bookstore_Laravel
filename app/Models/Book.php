<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'price',
        'stock',
        'cover_image',
        'sold_count',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getIsOutOfStockAttribute(): bool
    {
        return $this->stock <= 0;
    }

    public function scopeSearch($query, $keyword)
    {
        if (!$keyword) {
            return $query;
        }

        return $query->where('title', 'like', "%{$keyword}%")
            ->orWhere('author', 'like', "%{$keyword}%");
    }
}
