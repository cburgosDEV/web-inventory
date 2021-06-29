<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\PurchaseDetailViewModel;
use App\Models\PurchaseDetail;

class PurchaseDetailMapper
{
    public function modelToViewModel(PurchaseDetail $model)
    {
        $viewModel = new PurchaseDetailViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new PurchaseDetail();
        $model->id = $object['id'];
        $model->unitaryPrice = $object['unitaryPrice'];
        $model->quantity = $object['quantity'];
        $model->subTotal = $object['subTotal'];
        $model->idPurchase = $object['idPurchase'];
        $model->idProduct = $object['idProduct'];

        return $model;
    }
}
