<?php

namespace App\Architecture\ViewModels;

use App\Models\Sale;

class SaleViewModel
{
    protected $id;
    protected $totalPrice;
    protected $state;
    protected $idCustomer;

    public function __construct()
    {

    }

    public function generateViewModel(Sale $model)
    {
        $this->id = $model->id;
        $this->totalPrice = $model->totalPrice;
        $this->state = $model->state;
        $this->idCustomer = $model->idCustomer;

        return $this;
    }
}
