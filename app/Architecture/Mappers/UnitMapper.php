<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\UnitViewModel;
use App\Models\Unit;

class UnitMapper
{
    public function modelToViewModel(Unit $model)
    {
        $viewModel = new UnitViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new Unit();
        $model->id = $object['id'];
        $model->name = $object['name'];
        $model->symbol = $object['symbol'];
        $model->state = $object['state'];

        return $model;
    }
}
