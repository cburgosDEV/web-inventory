<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Mappers\SupplierMapper;
use App\Architecture\Structure\Repositories\SupplierRepository;

class SupplierService
{
    protected $supplierRepository;
    protected $supplierMapper;

    public function __construct
    (
        SupplierRepository $supplierRepository,
        SupplierMapper $supplierMapper
    )
    {
        $this->supplierRepository = $supplierRepository;
        $this->supplierMapper = $supplierMapper;
    }

    public function getById($id)
    {
        if($id == 0) return $this->supplierRepository->buildEmptyModel();
        return $this->supplierRepository->getById($id);
    }

    public function getAllPaginateToIndex($filterText)
    {
        return  $this->supplierRepository->getAllPaginateToIndex(10, $filterText);
    }

    public function store($request)
    {
        if($request->get('id') == 0) {
            $model = $this->supplierMapper->objectRequestToModel($request->all());

            return $this->supplierRepository->store($model);
        }
        else {
            $model = $this->supplierRepository->getById($request->get('id'));
            $model->fill($request->all());

            return $this->supplierRepository->store($model);
        }
    }
}
