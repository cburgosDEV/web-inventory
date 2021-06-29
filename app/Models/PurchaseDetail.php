<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = 'purchase_detail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'unitaryPrice',
        'quantity',
        'subTotal',
        'idPurchase',
        'idProduct',
    ];

    public function scopeFiltersToPurchaseDetailIndex($query, $filters)
    {

    }
}
