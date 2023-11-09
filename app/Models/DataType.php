<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function specifications(): HasMany
    {
        return $this->hasMany(Specification::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
