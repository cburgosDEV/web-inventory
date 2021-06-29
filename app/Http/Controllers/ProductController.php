<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\DropdownService;
use App\Architecture\Structure\Services\ProductService;
use App\Http\Request\StoreProduct;

class ProductController
{
    protected $productService;
    protected $dropdownService;

    public function __construct
    (
        ProductService $productService,
        DropdownService $dropdownService
    )
    {
        $this->productService = $productService;
        $this->dropdownService = $dropdownService;
    }

    public function index()
    {
        return view('project_views.product.index');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->productService->getAllPaginateToIndex($filterText));
    }

    public function jsonCreate()
    {
        return response()->json(
            [
                'viewModel' => $this->productService->getById(0),
                'dropdownUnit' => $this->dropdownService->UnitDropdown()
            ]
        );
    }

    public function store(StoreProduct $request)
    {
        $request->validated();

        return response()->json($this->productService->store($request));
    }

    public function jsonDetail($idProduct)
    {
        return response()->json
        (
            [
                'viewModel' => $this->productService->getById($idProduct),
                'dropdownUnit' => $this->dropdownService->UnitDropdown()
            ]
        );
    }
}
