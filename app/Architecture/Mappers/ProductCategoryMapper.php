<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\ProductCategoryViewModel;
use App\Models\ProductCategory;

class ProductCategoryMapper
{
    public function modelToViewModel(ProductCategory $model)
    {
        $viewModel = new ProductCategoryViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new ProductCategory();
        $model->id = $object['id'];
        $model->state = $object['state'];
        $model->idProduct = $object['idProduct'];
        $model->idCategory = $object['idCategory'];

        return $model;
    }
}
