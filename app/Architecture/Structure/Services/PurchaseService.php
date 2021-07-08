<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Mappers\PurchaseDetailMapper;
use App\Architecture\Mappers\PurchaseMapper;
use App\Architecture\Structure\Repositories\PurchaseDetailRepository;
use App\Architecture\Structure\Repositories\PurchaseRepository;

class PurchaseService
{
    protected $purchaseRepository;
    protected $purchaseMapper;
    protected $purchaseDetailRepository;
    protected $purchaseDetailMapper;
    protected $productService;

    public function __construct
    (
        PurchaseRepository $purchaseRepository,
        PurchaseDetailRepository $purchaseDetailRepository,
        PurchaseMapper $purchaseMapper,
        PurchaseDetailMapper $purchaseDetailMapper,
        ProductService $productService
    )
    {
        $this->purchaseRepository = $purchaseRepository;
        $this->purchaseMapper = $purchaseMapper;
        $this->purchaseDetailRepository = $purchaseDetailRepository;
        $this->purchaseDetailMapper = $purchaseDetailMapper;
        $this->productService = $productService;
    }

    public function getById($id)
    {
        if($id == 0) return $this->purchaseRepository->buildEmptyModel();
        return $this->purchaseRepository->getById($id);
    }

    public function getAllPaginateToIndex($filterText)
    {
        return  $this->purchaseRepository->getAllPaginateToIndex(10, $filterText);
    }

    public function store($request)
    {
        if($request->get('id')==0){
            $model = $this->purchaseMapper->objectRequestToModel($request->all());
            $response = $this->purchaseRepository->store($model);

            foreach ($request->get('listDetail') as $detail){
                $purchaseDetailViewModel = $this->purchaseDetailRepository->buildEmptyModel();
                $purchaseDetailViewModel['unitaryPrice'] = $detail['unitaryPrice'];
                $purchaseDetailViewModel['quantity'] = $detail['quantity'];
                $purchaseDetailViewModel['subTotal'] = $detail['subTotal'];
                $purchaseDetailViewModel['idPurchase'] = $response->id;
                $purchaseDetailViewModel['idProduct'] = $detail['idProduct'];

                $purchaseDetailModel = $this->purchaseDetailMapper->objectRequestToModel($purchaseDetailViewModel);
                $responsePurchaseDetail = $this->purchaseDetailRepository->store($purchaseDetailModel);

                if(is_numeric($responsePurchaseDetail->id)){
                    $this->productService->addStock($detail['idProduct'], $detail['quantity']);
                    $this->productService->setNewMinPrice($detail['idProduct'], $detail['unitaryPrice']);
                }
            }
            return is_numeric($response->id) > 0 ?? false;
        } else {
            $model = $this->purchaseRepository->getById($request->get('id'));
            $model->fill($request->all());
            $response = $this->purchaseRepository->store($model);
            return $this->softDelete($response->id);
        }
    }

    public function softDelete($idPurchase)
    {
        $listPurchaseDetail = $this->purchaseDetailRepository->getAllByPurchase($idPurchase);

        foreach ($listPurchaseDetail as $purchaseDetail){
            $this->productService->reduceStock($purchaseDetail['idProduct'], $purchaseDetail['quantity']);
        }

        return true;
    }
}
