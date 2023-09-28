<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_code",
        "product_name",
        "product_price",
        "product_image",
        "product_active",
        "product_created_by",
        "product_modified_by",
    ];

    public function details(): HasMany
    {
        return $this->hasMany(Detail::class);
    }
}
