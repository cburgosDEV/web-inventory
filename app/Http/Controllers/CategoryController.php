<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\CategoryService;
use App\Http\Request\StoreCategory;

class CategoryController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('project_views.category.index');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->categoryService->getAllPaginateToIndex($filterText));
    }

    public function jsonCreate()
    {
        return response()->json($this->categoryService->getById(0));
    }

    public function store(StoreCategory $request)
    {
        $request->validated();

        return response()->json($this->categoryService->store($request));
    }

    public function jsonDetail($idCategory)
    {
        return response()->json($this->categoryService->getById($idCategory));
    }
}
