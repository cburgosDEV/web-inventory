<?php

namespace App\Architecture\Structure\Repositories;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;

class DropdownRepository
{
    public function UnitDropdown()
    {
        return Unit::select('unit.id as value', 'unit.name as text')
            ->where('unit.state', true)
            ->get();
    }

    public function SupplierDropdown()
    {
        return Supplier::select('supplier.id as value', 'supplier.name as text')
            ->where('supplier.state', true)
            ->get();
    }

    public function ProductDropdown()
    {
        return Product::select('product.id as value', 'product.name as text', 'unit.symbol as unitSymbol')
            ->join('unit', 'product.idUnit', 'unit.id')
            ->where('product.state', true)
            ->get();
    }

    public function CustomerDropdown()
    {
        return Customer::select('customer.id as value', 'customer.name as text')
            ->where('customer.state', true)
            ->get();
    }
}
