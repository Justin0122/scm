<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'size_group_sizes', 'size_group_id', 'size_id');
    }

}
