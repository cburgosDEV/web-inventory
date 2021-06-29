<?php

namespace App\Architecture\Structure\Repositories;

use App\Models\PurchaseDetail;

class PurchaseDetailRepository extends PurchaseDetail
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'unitaryPrice' => 0,
            'quantity' => 0,
            'subTotal' => 0,
            'idPurchase' => 0,
            'idProduct' => 0,
        ];
    }

    public function getById($id)
    {
        return PurchaseDetailRepository::select('purchase_detail.*')
            ->where('purchase_detail.id', $id)
            ->first();
    }

    public function store(PurchaseDetail $purchaseDetail)
    {
        if($purchaseDetail->id == 0) {
            $purchaseDetail->save();
        } else {
            $purchaseDetail->update();
        }
        return $purchaseDetail;
    }

    public function getAllToIndex($filterText)
    {
        return PurchaseDetailRepository::select('purchase_detail.*')
            ->filtersToPurchaseDetailIndex($filterText)
            ->get();
    }

    public function getAllByPurchase($idPurchase)
    {
        return PurchaseDetailRepository::select('purchase_detail.*')
            ->where('purchase_detail.idPurchase', $idPurchase)
            ->get();
    }
}
