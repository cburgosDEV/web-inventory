<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\ExpenseService;
use App\Http\Request\StoreExpense;

class ExpenseController
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function index()
    {
        return view('project_views.expense.index');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->expenseService->getAllPaginateToIndex($filterText));
    }

    public function jsonCreate()
    {
        return response()->json($this->expenseService->getById(0));
    }

    public function store(StoreExpense $request)
    {
        $request->validated();

        return response()->json($this->expenseService->store($request));
    }

    public function jsonDetail($idExpense)
    {
        return response()->json($this->expenseService->getById($idExpense));
    }
}
