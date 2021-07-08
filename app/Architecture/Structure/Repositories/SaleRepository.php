<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleRepository extends Sale
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'totalPrice' => 0,
            'state' => true,
            'idCustomer' => null,
            'listDetail' => [],
        ];
    }

    public function getById($id)
    {
        return SaleRepository::select('sale.*')
            ->where('sale.id', $id)
            ->first();
    }

    public function store(Sale $sale)
    {
        if($sale->id == 0) {
            $sale->save();
        } else {
            $sale->update();
        }
        return $sale;
    }

    public function getAllPaginateToIndex($pages, $filterText)
    {
        $model = SaleRepository::select
        (
            'sale.*',
            DB::raw('DATE_FORMAT(sale.created_at, "%d/%m/%y %h:%i %p") as createdDate'),
            'customer.name as customerName'
        )
            ->join('customer', 'sale.idCustomer', 'customer.id')
            ->where('sale.state', true)
            ->with(['detail' => function($query){
                $query->select('sale_detail.*', 'product.name as productName')
                    ->join('product', 'sale_detail.idProduct', 'product.id');
            }])
            ->orderBy('sale.created_at', 'desc')
            ->filtersToSaleIndex($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }
}
