<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Mappers\SaleDetailMapper;
use App\Architecture\Mappers\SaleMapper;
use App\Architecture\Structure\Repositories\SaleDetailRepository;
use App\Architecture\Structure\Repositories\SaleRepository;

class SaleService
{
    protected $saleRepository;
    protected $saleMapper;
    protected $saleDetailRepository;
    protected $saleDetailMapper;
    protected $productService;

    public function __construct
    (
        SaleRepository $saleRepository,
        SaleDetailRepository $saleDetailRepository,
        SaleMapper $saleMapper,
        SaleDetailMapper $saleDetailMapper,
        ProductService $productService
    )
    {
        $this->saleRepository = $saleRepository;
        $this->saleMapper = $saleMapper;
        $this->saleDetailRepository = $saleDetailRepository;
        $this->saleDetailMapper = $saleDetailMapper;
        $this->productService = $productService;
    }

    public function getById($id)
    {
        if($id == 0) return $this->saleRepository->buildEmptyModel();
        return $this->saleRepository->getById($id);
    }

    public function getAllPaginateToIndex($filterText)
    {
        return  $this->saleRepository->getAllPaginateToIndex(10, $filterText);
    }

    public function store($request)
    {
        if($request->get('id')==0){
            $validation = $this->validatePriceAndStockByProduct($request->get('listDetail'));
            if(!$validation) return false;

            $model = $this->saleMapper->objectRequestToModel($request->all());
            $response = $this->saleRepository->store($model);

            foreach ($request->get('listDetail') as $detail){
                $saleDetailViewModel = $this->saleDetailRepository->buildEmptyModel();
                $saleDetailViewModel['unitaryPrice'] = $detail['unitaryPrice'];
                $saleDetailViewModel['quantity'] = $detail['quantity'];
                $saleDetailViewModel['subTotal'] = $detail['subTotal'];
                $saleDetailViewModel['idSale'] = $response->id;
                $saleDetailViewModel['idProduct'] = $detail['idProduct'];

                $saleDetailModel = $this->saleDetailMapper->objectRequestToModel($saleDetailViewModel);
                $responseSaleDetail = $this->saleDetailRepository->store($saleDetailModel);

                if(is_numeric($responseSaleDetail->id)){
                    $this->productService->reduceStock($detail['idProduct'], $detail['quantity']);
                }
            }
            return is_numeric($response->id) > 0 ?? false;
        } else {
            $model = $this->saleRepository->getById($request->get('id'));
            $model->fill($request->all());
            $response = $this->saleRepository->store($model);
            return $this->softDelete($response->id);
        }
    }

    public function softDelete($idSale)
    {
        $listSaleDetail = $this->saleDetailRepository->getAllBySale($idSale);

        foreach ($listSaleDetail as $saleDetail){
            $this->productService->addStock($saleDetail['idProduct'], $saleDetail['quantity']);
        }

        return true;
    }

    public function validatePriceAndStockByProduct($listDetail){
        foreach ($listDetail as $detail){
            $stock = intval($detail['stock']);
            $minPrice = intval($detail['minPrice']);
            $quantity = intval($detail['quantity']);
            $unitaryPrice = intval($detail['unitaryPrice']);
            if($unitaryPrice<=0||$quantity<=0||$minPrice>$unitaryPrice||$stock<$quantity)return false;
        }
        return true;
    }
}
