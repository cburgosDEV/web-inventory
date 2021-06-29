<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchase';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'totalPrice',
        'state',
        'idSupplier',
    ];

    public function scopeFiltersToPurchaseIndex($query, $filters)
    {
        $query->where('purchase.totalPrice', 'like', '%' . $filters . '%')
            ->orWhere('supplier.name', 'like', '%' . $filters . '%');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\PurchaseDetail', 'idPurchase');
    }
}
