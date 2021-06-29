<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\DropdownService;
use App\Architecture\Structure\Services\PurchaseService;
use App\Http\Request\StorePurchase;
use App\Http\Request\StorePurchaseDetail;

class PurchaseController
{
    protected $purchaseService;
    protected $dropdownService;

    public function __construct(PurchaseService $purchaseService, DropdownService $dropdownService)
    {
        $this->purchaseService = $purchaseService;
        $this->dropdownService = $dropdownService;
    }

    public function index()
    {
        return view('project_views.purchase.index');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->purchaseService->getAllPaginateToIndex($filterText));
    }

    public function jsonCreate()
    {
        return response()->json(
            [
                'model'=>$this->purchaseService->getById(0),
                'productsDropdown'=> $this->dropdownService->ProductDropdown(),
                'suppliersDropdown'=> $this->dropdownService->SupplierDropdown(),
            ]
        );
    }

    public function store(StorePurchase $request)
    {
        $request->validated();

        return response()->json($this->purchaseService->store($request));
    }

    public function jsonDetail($idPurchase)
    {
        return response()->json($this->purchaseService->getById($idPurchase));
    }

    public function checkFormDetail(StorePurchaseDetail $request)
    {
        $request->validated();

        return response()->json(true);
    }
}
