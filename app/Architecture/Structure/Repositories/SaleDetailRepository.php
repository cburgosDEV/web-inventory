<?php

namespace App\Architecture\Structure\Repositories;

use App\Models\SaleDetail;

class SaleDetailRepository extends SaleDetail
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'unitaryPrice' => 0,
            'quantity' => 0,
            'subTotal' => 0,
            'idSale' => 0,
            'idProduct' => 0,
        ];
    }

    public function getById($id)
    {
        return SaleDetailRepository::select('sale_detail.*')
            ->where('sale_detail.id', $id)
            ->first();
    }

    public function store(SaleDetail $saleDetail)
    {
        if($saleDetail->id == 0) {
            $saleDetail->save();
        } else {
            $saleDetail->update();
        }
        return $saleDetail;
    }

    public function getAllToIndex($filterText)
    {
        return SaleDetailRepository::select('sale_detail.*')
            ->filtersToSaleDetailIndex($filterText)
            ->get();
    }

    public function getAllBySale($idSale)
    {
        return SaleDetailRepository::select('sale_detail.*')
            ->where('sale_detail.idSale', $idSale)
            ->get();
    }
}
