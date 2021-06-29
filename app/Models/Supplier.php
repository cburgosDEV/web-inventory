<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'dni',
        'ruc',
        'phone',
        'address',
        'state',
        'idTypePerson',
    ];

    public function scopeFiltersToSupplierIndex($query, $filters)
    {
        $query->where('supplier.name', 'like', '%' . $filters . '%')
            ->orWhere('supplier.dni', 'like', '%' . $filters . '%')
            ->orWhere('supplier.ruc', 'like', '%' . $filters . '%')
            ->orWhere('type_person.name', 'like', '%' . $filters . '%');
    }
}
