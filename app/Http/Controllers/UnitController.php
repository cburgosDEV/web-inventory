<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\UnitService;
use App\Http\Request\StoreUnit;

class UnitController
{
    protected $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index()
    {
        return view('project_views.unit.index');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->unitService->getAllPaginateToIndex($filterText));
    }

    public function jsonCreate()
    {
        return response()->json($this->unitService->getById(0));
    }

    public function store(StoreUnit $request)
    {
        $request->validated();

        return response()->json($this->unitService->store($request));
    }

    public function jsonDetail($idUnit)
    {
        return response()->json($this->unitService->getById($idUnit));
    }
}
