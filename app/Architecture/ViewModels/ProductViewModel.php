<?php

namespace App\Architecture\ViewModels;

use App\Models\Product;

class ProductViewModel
{
    protected $id;
    protected $name;
    protected $description;
    protected $minPrice;
    protected $stock;
    protected $state;
    protected $idUnit;

    public function __construct()
    {

    }

    public function generateViewModel(Product $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->description = $model->description;
        $this->minPrice = $model->minPrice;
        $this->stock = $model->stock;
        $this->state = $model->state;
        $this->idUnit = $model->idUnit;

        return $this;
    }
}
