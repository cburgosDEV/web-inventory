<?php

namespace App\Architecture\ViewModels;

use App\Models\Purchase;

class PurchaseViewModel
{
    protected $id;
    protected $totalPrice;
    protected $state;
    protected $idSupplier;

    public function __construct()
    {

    }

    public function generateViewModel(Purchase $model)
    {
        $this->id = $model->id;
        $this->totalPrice = $model->totalPrice;
        $this->state = $model->state;
        $this->idSupplier = $model->idSupplier;

        return $this;
    }
}
