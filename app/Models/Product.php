<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'description',
        'minPrice',
        'stock',
        'state',
        'idUnit',
    ];

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage', 'idProduct');
    }

    public function scopeFiltersToProductIndex($query, $filters)
    {
        $query->where('product.name', 'like', '%' . $filters . '%')
            ->orWhere('product.stock', 'like', '%' . $filters . '%');
    }
}
