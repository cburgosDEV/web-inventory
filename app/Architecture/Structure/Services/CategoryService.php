<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Mappers\CategoryMapper;
use App\Architecture\Structure\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;
    protected $categoryMapper;

    public function __construct
    (
        CategoryRepository $categoryRepository,
        CategoryMapper $categoryMapper
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryMapper = $categoryMapper;
    }

    public function getById($id)
    {
        if($id == 0) return $this->categoryRepository->buildEmptyModel();
        return $this->categoryRepository->getById($id);
    }

    public function getAllPaginateToIndex($filterText)
    {
        return  $this->categoryRepository->getAllPaginateToIndex(10, $filterText);
    }

    public function store($request)
    {
        if($request->get('id') == 0) {
            $model = $this->categoryMapper->objectRequestToModel($request->all());

            return $this->categoryRepository->store($model);
        }
        else {
            $model = $this->categoryRepository->getById($request->get('id'));
            $model->fill($request->all());

            return $this->categoryRepository->store($model);
        }
    }
}
