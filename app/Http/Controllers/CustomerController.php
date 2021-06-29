<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\CustomerService;
use App\Http\Request\StoreCustomer;

class CustomerController
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        return view('project_views.customer.index');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->customerService->getAllPaginateToIndex($filterText));
    }

    public function jsonCreate()
    {
        return response()->json($this->customerService->getById(0));
    }

    public function store(StoreCustomer $request)
    {
        $request->validated();

        return response()->json($this->customerService->store($request));
    }

    public function jsonDetail($idCustomer)
    {
        return response()->json($this->customerService->getById($idCustomer));
    }
}
