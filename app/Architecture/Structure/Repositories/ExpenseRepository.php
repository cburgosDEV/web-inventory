<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\Expense;

class ExpenseRepository extends Expense
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'name' => '',
            'amount' => 0,
            'state' => true,
        ];
    }

    public function getById($id)
    {
        return ExpenseRepository::select('expense.*')
            ->where('expense.id', $id)
            ->first();
    }

    public function store(Expense $expense)
    {
        if($expense->id == 0) {
            return $expense->save();
        } else {
            return $expense->update();
        }
    }

    public function getAllPaginateToIndex($pages, $filterText)
    {
        $model = ExpenseRepository::select('expense.*')
            ->where('expense.state', true)
            ->filtersToExpenseIndex($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }
}
