<?php

namespace App\Architecture\ViewModels;

use App\Models\ProductImage;

class ProductImageViewModel
{
    protected $id;
    protected $url;
    protected $isPrincipal;
    protected $state;
    protected $idProduct;

    public function __construct()
    {

    }

    public function generateViewModel(ProductImage $model)
    {
        $this->id = $model->id;
        $this->url = $model->url;
        $this->isPrincipal = $model->isPrincipal;
        $this->state = $model->state;
        $this->idProduct = $model->idProduct;

        return $this;
    }
}
