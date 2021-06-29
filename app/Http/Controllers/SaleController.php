<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\DropdownService;
use App\Architecture\Structure\Services\SaleService;
use App\Http\Request\StoreSale;
use App\Http\Request\StoreSaleDetail;

class SaleController
{
    protected $saleService;
    protected $dropdownService;

    public function __construct
    (
        SaleService $saleService,
        DropdownService $dropdownService
    )
    {
        $this->saleService = $saleService;
        $this->dropdownService = $dropdownService;
    }

    public function index()
    {
        return view('project_views.sale.index');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->saleService->getAllPaginateToIndex($filterText));
    }

    public function jsonCreate()
    {
        return response()->json(
            [
                'model'=>$this->saleService->getById(0),
                'productsDropdown'=> $this->dropdownService->ProductDropdown(),
                'customersDropdown'=> $this->dropdownService->CustomerDropdown(),
            ]
        );
    }

    public function store(StoreSale $request)
    {
        $request->validated();

        return response()->json($this->saleService->store($request));
    }

    public function jsonDetail($idSale)
    {
        return response()->json($this->saleService->getById($idSale));
    }

    public function checkFormDetail(StoreSaleDetail $request)
    {
        $request->validated();

        return response()->json(true);
    }
}
