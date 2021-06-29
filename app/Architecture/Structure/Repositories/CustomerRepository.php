<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\Customer;

class CustomerRepository extends Customer
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
        return CustomerRepository::select('customer.*')
            ->where('customer.id', $id)
            ->first();
    }

    public function store(Customer $customer)
    {
        if($customer->id == 0) {
            return $customer->save();
        } else {
            return $customer->update();
        }
    }

    public function getAllPaginateToIndex($pages, $filterText)
    {
        $model = CustomerRepository::select('customer.*', 'type_person.name as nameTypePerson')
            ->join('type_person', 'customer.idTypePerson', 'type_person.id')
            ->where('customer.state', true)
            ->filtersToCustomerIndex($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }
}
