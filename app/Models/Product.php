<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'stock',
        // 'category',
    ];

    protected $casts = [
        'price' => 'double',
        'stock' => 'integer',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category', 'like', '%'.$category.'%');
        });
    }
}
