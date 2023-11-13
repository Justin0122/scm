<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'key',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
