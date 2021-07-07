<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\Product;

class ProductRepository extends Product
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'name' => '',
            'description' => '',
            'minPrice' => 0,
            'stock' => 0,
            'state' => true,
            'idUnit' => 0,
            'listImage' => [],
            'listCategory' => [],
        ];
    }

    public function getById($id)
    {
        return ProductRepository::select('product.*')
            ->where('product.id', $id)
            ->with(['images' => function ($query){
                $query->orderBy('isPrincipal', 'DESC');
            }])
            ->with(['categories' => function ($query){
                $query->where('state', true);
            }])
            ->first();
    }

    public function getByIdSimple($id)
    {
        return ProductRepository::select
        (
            'product.id as idProduct',
            'product.name as productName',
            'product.stock as stock',
            'product.minPrice',
            'unit.symbol as unitSymbol'
        )
            ->join('unit', 'product.idUnit', 'unit.id')
            ->where('product.id', $id)
            ->first();
    }

    public function store(Product $product)
    {
        if($product->id == 0) {
            $product->save();
        } else {
            $product->update();
        }
        return $product;
    }

    public function getAllPaginateToIndex($pages, $filterText)
    {
        $model = ProductRepository::select('product.*', 'unit.name as nameUnit')
            ->join('unit', 'product.idUnit', 'unit.id')
            ->where('product.state', true)
            ->filtersToProductIndex($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }
}
