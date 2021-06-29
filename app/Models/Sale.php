<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sale';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'totalPrice',
        'state',
        'idCustomer',
    ];

    public function scopeFiltersToSaleIndex($query, $filters)
    {
        $query->where('sale.totalPrice', 'like', '%' . $filters . '%')
            ->orWhere('customer.name', 'like', '%' . $filters . '%');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\SaleDetail', 'idSale');
    }
}
