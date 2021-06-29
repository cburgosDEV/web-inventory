<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\SupplierService;
use App\Http\Request\StoreSupplier;

class SupplierController
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index()
    {
        return view('project_views.supplier.index');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->supplierService->getAllPaginateToIndex($filterText));
    }

    public function jsonCreate()
    {
        return response()->json($this->supplierService->getById(0));
    }

    public function store(StoreSupplier $request)
    {
        $request->validated();

        return response()->json($this->supplierService->store($request));
    }

    public function jsonDetail($idSupplier)
    {
        return response()->json($this->supplierService->getById($idSupplier));
    }
}
