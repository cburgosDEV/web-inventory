<?php

namespace App\Architecture\ViewModels;

use App\Models\ProductCategory;

class ProductCategoryViewModel
{
    protected $id;
    protected $state;
    protected $idProduct;
    protected $idCategory;

    public function __construct()
    {

    }

    public function generateViewModel(ProductCategory $model)
    {
        $this->id = $model->id;
        $this->state = $model->state;
        $this->idProduct = $model->idProduct;
        $this->idCategory = $model->idCategory;

        return $this;
    }
}
