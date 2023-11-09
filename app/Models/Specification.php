<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'data_type'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_specification')
            ->withPivot('stock');
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'supplier_specification')
            ->withPivot('value');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('key', 'like', '%' . $search . '%');
    }
}
