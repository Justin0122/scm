<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'category_id',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'product_specifications', 'product_id', 'size_id')
            ->withPivot('stock');
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'product_specifications', 'product_id', 'color_id')
            ->withPivot('stock');
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'product_specifications', 'product_id', 'supplier_id')
            ->withPivot('stock');
    }

    public function productSpecifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function getStockAttribute()
    {
        return $this->productSpecifications->sum('stock');
    }

    public function totalStockForColorSizeAndSupplier($colorId, $sizeId, $supplierId)
    {
        $query = $this->productSpecifications();

        if ($colorId) {
            $query->where('color_id', $colorId);
        }

        if ($sizeId) {
            $query->where('size_id', $sizeId);
        }

        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        return $query->sum('stock');
    }

}
