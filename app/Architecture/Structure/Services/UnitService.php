<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Mappers\UnitMapper;
use App\Architecture\Structure\Repositories\UnitRepository;

class UnitService
{
    protected $unitRepository;
    protected $unitMapper;

    public function __construct
    (
        UnitRepository $unitRepository,
        UnitMapper $unitMapper
    )
    {
        $this->unitRepository = $unitRepository;
        $this->unitMapper = $unitMapper;
    }

    public function getById($id)
    {
        if($id == 0) return $this->unitRepository->buildEmptyModel();

        return $this->unitRepository->getById($id);
    }

    public function getAllPaginateToIndex($filterText)
    {
        return  $this->unitRepository->getAllPaginateToIndex(10, $filterText);
    }

    public function store($request)
    {
        if($request->get('id') == 0) {
            $model = $this->unitMapper->objectRequestToModel($request->all());

            return $this->unitRepository->store($model);
        }
        else {
            $model = $this->unitRepository->getById($request->get('id'));
            $model->fill($request->all());

            return $this->unitRepository->store($model);
        }
    }
}
