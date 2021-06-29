<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class PurchaseRepository extends Purchase
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'totalPrice' => 0,
            'state' => true,
            'idSupplier' => null,
            'listDetail' => [],
        ];
    }

    public function getById($id)
    {
        return PurchaseRepository::select('purchase.*')
            ->where('purchase.id', $id)
            ->first();
    }

    public function store(Purchase $purchase)
    {
        if($purchase->id == 0) {
            $purchase->save();
        } else {
            $purchase->update();
        }
        return $purchase;
    }

    public function getAllPaginateToIndex($pages, $filterText)
    {
        $model = PurchaseRepository::select
        (
            'purchase.*',
            DB::raw('DATE_FORMAT(purchase.created_at, "%d/%m/%y %h:%i %p") as createdDate'),
            'supplier.name as supplierName'
        )
            ->join('supplier', 'purchase.idSupplier', 'supplier.id')
            ->where('purchase.state', true)
            ->with(['detail' => function($query){
                $query->select('purchase_detail.*', 'product.name as productName')
                    ->join('product', 'purchase_detail.idProduct', 'product.id');
            }])
            ->filtersToPurchaseIndex($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }
}
