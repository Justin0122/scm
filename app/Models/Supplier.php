<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_supplier')
            ->withPivot('stock');
    }

    public function specifications(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'supplier_specification')
            ->withPivot('value');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

}
