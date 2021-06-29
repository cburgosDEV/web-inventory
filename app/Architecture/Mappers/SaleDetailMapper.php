<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\SaleDetailViewModel;
use App\Models\SaleDetail;

class SaleDetailMapper
{
    public function modelToViewModel(SaleDetail $model)
    {
        $viewModel = new SaleDetailViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new SaleDetail();
        $model->id = $object['id'];
        $model->unitaryPrice = $object['unitaryPrice'];
        $model->quantity = $object['quantity'];
        $model->subTotal = $object['subTotal'];
        $model->idSale = $object['idSale'];
        $model->idProduct = $object['idProduct'];

        return $model;
    }
}
