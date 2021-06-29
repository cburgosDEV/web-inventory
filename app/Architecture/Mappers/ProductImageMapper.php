<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\ProductImageViewModel;
use App\Models\ProductImage;

class ProductImageMapper
{
    public function modelToViewModel(ProductImage $model)
    {
        $viewModel = new ProductImageViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new ProductImage();
        $model->id = $object['id'];
        $model->url = $object['url'];
        $model->isPrincipal = $object['isPrincipal'];
        $model->state = $object['state'];
        $model->idProduct = $object['idProduct'];

        return $model;
    }
}
