<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Mappers\CustomerMapper;
use App\Architecture\Structure\Repositories\CustomerRepository;

class CustomerService
{
    protected $customerRepository;
    protected $customerMapper;

    public function __construct
    (
        CustomerRepository $customerRepository,
        CustomerMapper $customerMapper
    )
    {
        $this->customerRepository = $customerRepository;
        $this->customerMapper = $customerMapper;
    }

    public function getById($id)
    {
        if($id == 0) return $this->customerRepository->buildEmptyModel();
        return $this->customerRepository->getById($id);
    }

    public function getAllPaginateToIndex($filterText)
    {
        return  $this->customerRepository->getAllPaginateToIndex(10, $filterText);
    }

    public function store($request)
    {
        if($request->get('id') == 0) {
            $model = $this->customerMapper->objectRequestToModel($request->all());

            return $this->customerRepository->store($model);
        }
        else {
            $model = $this->customerRepository->getById($request->get('id'));
            $model->fill($request->all());

            return $this->customerRepository->store($model);
        }
    }
}
