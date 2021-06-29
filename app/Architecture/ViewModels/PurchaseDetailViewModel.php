<?php

namespace App\Architecture\ViewModels;

use App\Models\PurchaseDetail;

class PurchaseDetailViewModel
{
    protected $id;
    protected $unitaryPrice;
    protected $quantity;
    protected $subTotal;
    protected $idPurchase;
    protected $idProduct;

    public function __construct()
    {

    }

    public function generateViewModel(PurchaseDetail $model)
    {
        $this->id = $model->id;
        $this->unitaryPrice = $model->unitaryPrice;
        $this->quantity = $model->quantity;
        $this->subTotal = $model->subTotal;
        $this->idPurchase = $model->idPurchase;
        $this->idProduct = $model->idProduct;

        return $this;
    }
}
