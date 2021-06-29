<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\PurchaseViewModel;
use App\Models\Purchase;

class PurchaseMapper
{
    public function modelToViewModel(Purchase $model)
    {
        $viewModel = new PurchaseViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new Purchase();
        $model->id = $object['id'];
        $model->totalPrice = $object['totalPrice'];
        $model->state = $object['state'];
        $model->idSupplier = $object['idSupplier'];

        return $model;
    }
}
