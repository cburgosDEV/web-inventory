<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\CategoryViewModel;
use App\Models\Category;

class CategoryMapper
{
    public function modelToViewModel(Category $model)
    {
        $viewModel = new CategoryViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new Category();
        $model->id = $object['id'];
        $model->name = $object['name'];
        $model->state = $object['state'];

        return $model;
    }
}
