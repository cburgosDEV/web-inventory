<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = 'sale_detail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'unitaryPrice',
        'quantity',
        'subTotal',
        'idSale',
        'idProduct',
    ];

    public function scopeFiltersToSaleDetailIndex($query, $filters)
    {

    }
}
