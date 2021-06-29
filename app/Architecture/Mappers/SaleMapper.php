<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\SaleViewModel;
use App\Models\Sale;

class SaleMapper
{
    public function modelToViewModel(Sale $model)
    {
        $viewModel = new SaleViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new Sale();
        $model->id = $object['id'];
        $model->totalPrice = $object['totalPrice'];
        $model->state = $object['state'];
        $model->idCustomer = $object['idCustomer'];

        return $model;
    }
}
