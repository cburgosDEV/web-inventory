<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\CustomerViewModel;
use App\Models\Customer;

class CustomerMapper
{
    public function modelToViewModel(Customer $model)
    {
        $viewModel = new CustomerViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new Customer();
        $model->id = $object['id'];
        $model->name = $object['name'];
        $model->dni = $object['dni'];
        $model->ruc = $object['ruc'];
        $model->phone = $object['phone'];
        $model->address = $object['address'];
        $model->state = $object['state'];
        $model->idTypePerson = $object['idTypePerson'];

        return $model;
    }
}
