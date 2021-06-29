<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\ProductViewModel;
use App\Models\Product;

class ProductMapper
{
    public function modelToViewModel(Product $model)
    {
        $viewModel = new ProductViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new Product();
        $model->id = $object['id'];
        $model->name = $object['name'];
        $model->description = $object['description'];
        $model->minPrice = $object['minPrice'];
        $model->stock = $object['stock'];
        $model->state = $object['state'];
        $model->idUnit = $object['idUnit'];

        return $model;
    }
}
