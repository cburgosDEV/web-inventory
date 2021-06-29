<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\SupplierViewModel;
use App\Models\Supplier;

class SupplierMapper
{
    public function modelToViewModel(Supplier $model)
    {
        $viewModel = new SupplierViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new Supplier();
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
