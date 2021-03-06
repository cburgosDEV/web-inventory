<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_image';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'url',
        'isPrincipal',
        'state',
        'idProduct',
    ];
}
