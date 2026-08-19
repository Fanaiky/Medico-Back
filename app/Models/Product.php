<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'active_molecule',
        'price_ttc',
        'backup_stock',
        'max_order_limit',
    ];

    protected $with = ['images'];

    protected function casts(): array
    {
        return [
            'price_ttc' => 'decimal:2',
            'backup_stock' => 'integer',
            'max_order_limit' => 'integer',
        ];
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }
}