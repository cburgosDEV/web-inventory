<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Mappers\ExpenseMapper;
use App\Architecture\Structure\Repositories\ExpenseRepository;

class ExpenseService
{
    protected $expenseRepository;
    protected $expenseMapper;

    public function __construct
    (
        ExpenseRepository $expenseRepository,
        ExpenseMapper $expenseMapper
    )
    {
        $this->expenseRepository = $expenseRepository;
        $this->expenseMapper = $expenseMapper;
    }

    public function getById($id)
    {
        if($id == 0) return $this->expenseRepository->buildEmptyModel();
        return $this->expenseRepository->getById($id);
    }

    public function getAllPaginateToIndex($filterText)
    {
        return  $this->expenseRepository->getAllPaginateToIndex(10, $filterText);
    }

    public function store($request)
    {
        if($request->get('id') == 0) {
            $model = $this->expenseMapper->objectRequestToModel($request->all());

            return $this->expenseRepository->store($model);
        }
        else {
            $model = $this->expenseRepository->getById($request->get('id'));
            $model->fill($request->all());

            return $this->expenseRepository->store($model);
        }
    }
}
