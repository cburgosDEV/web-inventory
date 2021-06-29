<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
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

    public function scopeFiltersToCustomerIndex($query, $filters)
    {
        $query->where('customer.name', 'like', '%' . $filters . '%')
            ->orWhere('customer.dni', 'like', '%' . $filters . '%')
            ->orWhere('customer.ruc', 'like', '%' . $filters . '%')
            ->orWhere('type_person.name', 'like', '%' . $filters . '%');
    }
}
