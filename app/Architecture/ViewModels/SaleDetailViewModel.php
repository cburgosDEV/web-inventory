<?php

namespace App\Architecture\ViewModels;

use App\Models\SaleDetail;

class SaleDetailViewModel
{
    protected $id;
    protected $unitaryPrice;
    protected $quantity;
    protected $subTotal;
    protected $idSale;
    protected $idProduct;

    public function __construct()
    {

    }

    public function generateViewModel(SaleDetail $model)
    {
        $this->id = $model->id;
        $this->unitaryPrice = $model->unitaryPrice;
        $this->quantity = $model->quantity;
        $this->subTotal = $model->subTotal;
        $this->idSale = $model->idSale;
        $this->idProduct = $model->idProduct;

        return $this;
    }
}
