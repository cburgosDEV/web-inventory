<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\Supplier;

class SupplierRepository extends Supplier
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'name' => '',
            'dni' => '',
            'ruc' => '',
            'phone' => '',
            'address' => '',
            'state' => true,
            'idTypePerson' => 1,
        ];
    }

    public function getById($id)
    {
        return SupplierRepository::select('supplier.*')
            ->where('supplier.id', $id)
            ->first();
    }

    public function store(Supplier $supplier)
    {
        if($supplier->id == 0) {
            return $supplier->save();
        } else {
            return $supplier->update();
        }
    }

    public function getAllPaginateToIndex($pages, $filterText)
    {
        $model = SupplierRepository::select('supplier.*', 'type_person.name as nameTypePerson')
            ->join('type_person', 'supplier.idTypePerson', 'type_person.id')
            ->where('supplier.state', true)
            ->filtersToSupplierIndex($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }
}
