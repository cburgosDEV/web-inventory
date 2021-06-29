<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\ExpenseViewModel;
use App\Models\Expense;

class ExpenseMapper
{
    public function modelToViewModel(Expense $model)
    {
        $viewModel = new ExpenseViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new Expense();
        $model->id = $object['id'];
        $model->name = $object['name'];
        $model->amount = $object['amount'];
        $model->state = $object['state'];

        return $model;
    }
}
